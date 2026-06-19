<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Accounting\BankTransfer\BankTransfer;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class BankTransfersTest extends TestCase
{
    public function test_it_can_query_find_and_create_bank_transfers(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BankTransfers' => [[
                'BankTransferID' => 'transfer-1',
                'FromBankAccount' => ['AccountID' => 'bank-a'],
                'ToBankAccount' => ['AccountID' => 'bank-b'],
                'Amount' => 350.25,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BankTransfers' => [[
                'BankTransferID' => 'transfer-1',
                'FromBankAccount' => ['AccountID' => 'bank-a'],
                'ToBankAccount' => ['AccountID' => 'bank-b'],
                'Amount' => 350.25,
                'Date' => '2026-03-25T00:00:00',
                'CurrencyRate' => 1.0,
                'FromBankTransactionID' => 'from-txn-1',
                'ToBankTransactionID' => 'to-txn-1',
                'FromIsReconciled' => true,
                'ToIsReconciled' => false,
                'HasAttachments' => true,
                'CreatedDateUTC' => '2026-03-25T01:00:00',
                'ValidationErrors' => [['Message' => 'Bad transfer']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BankTransfers' => [[
                'BankTransferID' => 'transfer-2',
                'FromBankAccount' => ['AccountID' => 'bank-a'],
                'ToBankAccount' => ['AccountID' => 'bank-b'],
                'Amount' => 400,
                'Reference' => 'Sweep',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $transfers = $client->accounting()->bankTransfers()->where('Amount > :amount', amount: 100)->get();
        $transfer = $client->accounting()->bankTransfers()->find('transfer-1');
        $created = $client->accounting()->bankTransfers()->create()
            ->fromBankAccount('bank-a')
            ->toBankAccount('bank-b')
            ->amount(400)
            ->reference('Sweep')
            ->save();

        self::assertSame('/api.xro/2.0/BankTransfers', $transport->requests()[0]->path);
        self::assertSame('Amount > 100', $transport->requests()[0]->query['where']);
        self::assertNotNull($transfers->first());
        $found = $transfer;
        self::assertNotNull($found);
        self::assertSame('2026-03-25T00:00:00', $found->getDate());
        self::assertSame(1, $found->getCurrencyRate());
        self::assertSame('from-txn-1', $found->getFromBankTransactionID());
        self::assertSame('to-txn-1', $found->getToBankTransactionID());
        self::assertTrue($found->getFromIsReconciled());
        self::assertFalse($found->getToIsReconciled());
        self::assertTrue($found->getHasAttachments());
        self::assertSame('2026-03-25T01:00:00', $found->getCreatedDateUTC());
        self::assertCount(1, $found->getValidationErrors());
        self::assertSame('Bad transfer', $found->getValidationErrors()[0]->getMessage());
        self::assertSame('bank-a', $found->getFromBankAccount()?->getAccountID());
        self::assertSame('bank-b', $found->getToBankAccount()?->getAccountID());
        self::assertSame('/api.xro/2.0/BankTransfers/transfer-1', $transport->requests()[1]->path);
        $json2 = $transport->requests()[2]->json ?? [];
        $bt2 = Json::extractFirst($json2, 'BankTransfers');
        self::assertNotNull($bt2);
        self::assertSame('PUT', $transport->requests()[2]->method);
        self::assertSame('/api.xro/2.0/BankTransfers', $transport->requests()[2]->path);
        self::assertSame('bank-a', Json::extractObject($bt2, 'FromBankAccount')['AccountID']);
        self::assertSame('Sweep', $created->getReference());
    }

    public function test_it_builds_with_date_idempotency_and_saves_a_model(): void
    {
        $body = json_encode([
            'BankTransfers' => [[
                'BankTransferID' => 'transfer-1',
                'FromBankAccount' => ['AccountID' => 'bank-a'],
                'ToBankAccount' => ['AccountID' => 'bank-b'],
                'Amount' => 350.25,
                'Reference' => 'Sweep',
            ]],
        ], JSON_THROW_ON_ERROR);

        $transport = (new FakeTransport())
            ->push(new Response(200, body: $body))
            ->push(new Response(200, body: $body))
            ->push(new Response(200, body: $body));

        $bankTransfers = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->bankTransfers();

        $bankTransfers->create()
            ->fromBankAccount('bank-a')
            ->toBankAccount('bank-b')
            ->amount(350.25)
            ->date('2026-03-25')
            ->idempotencyKey('bt-key')
            ->save();

        self::assertSame('bt-key', $transport->requests()[0]->headers['Idempotency-Key']);
        $sent = Json::extractFirst($transport->requests()[0]->json ?? [], 'BankTransfers');
        self::assertNotNull($sent);
        self::assertSame('2026-03-25', $sent['Date'] ?? null);

        $transfer = $bankTransfers->get()->first();
        self::assertNotNull($transfer);
        self::assertSame('transfer-1', $transfer->getBankTransferID());
        self::assertSame('bank-a', $transfer->getFromBankAccountID());
        self::assertSame('bank-b', $transfer->getToBankAccountID());
        self::assertSame(350.25, $transfer->getAmount());

        $saved = $transfer->amount(360)->date('2026-04-01')->reference('Updated Sweep')->save();

        self::assertSame('/api.xro/2.0/BankTransfers', $transport->requests()[2]->path);
        $resaved = Json::extractFirst($transport->requests()[2]->json ?? [], 'BankTransfers');
        self::assertNotNull($resaved);
        self::assertSame('2026-04-01', $resaved['Date'] ?? null);
        self::assertSame('Updated Sweep', $resaved['Reference'] ?? null);
        self::assertSame('Sweep', $saved->getReference());

        self::assertNotSame([], $bankTransfers->scopes()->broad);
    }

    public function test_it_can_set_bank_accounts_by_id(): void
    {
        $transfer = (new BankTransfer())
            ->setFromBankAccountID('bank-a')
            ->setToBankAccountID('bank-b');

        self::assertSame('bank-a', $transfer->getFromBankAccountID());
        self::assertSame('bank-b', $transfer->getToBankAccountID());
        self::assertSame(['AccountID' => 'bank-a'], $transfer->getFromBankAccount()?->toRequest());
        self::assertSame(['AccountID' => 'bank-b'], $transfer->getToBankAccount()?->toRequest());

        $transfer->setFromBankAccountID(null)->setToBankAccountID(null);

        self::assertNull($transfer->getFromBankAccountID());
        self::assertNull($transfer->getToBankAccountID());
    }

    public function test_saving_a_bank_transfer_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('without a bound client context');

        (new BankTransfer())->amount(100)->save();
    }
}
