<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\BankTransaction\BankAccount;
use Sujip\Xero\Accounting\BankTransaction\BankTransaction;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class BankTransactionsTest extends TestCase
{
    public function test_it_can_query_and_find_bank_transactions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Status' => 'AUTHORISED',
                'Reference' => 'BT-1001',
                'Contact' => [
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                ],
                'BankAccount' => [
                    'AccountID' => 'account-1',
                ],
                'LineItems' => [[
                    'Description' => 'Office supplies',
                    'Quantity' => 1,
                    'UnitAmount' => 25,
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Status' => 'AUTHORISED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $transactions = $client->accounting()->bankTransactions()->where('Status == :status', status: 'AUTHORISED')->get();
        $transaction = $client->accounting()->bankTransactions()->find('bank-1');

        $firstTx = $transactions->first();
        self::assertNotNull($firstTx);
        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[0]->path);
        self::assertSame('Status == "AUTHORISED"', $transport->requests()[0]->query['where']);
        self::assertSame('/api.xro/2.0/BankTransactions/bank-1', $transport->requests()[1]->path);
        self::assertSame('bank-1', $transaction?->getBankTransactionID());
        self::assertSame('contact-1', $firstTx->getContact()?->getContactID());
        self::assertSame('account-1', $firstTx->getBankAccount()?->getAccountID());
        self::assertSame('Office supplies', $firstTx->getLineItems()[0]->getDescription());
    }

    public function test_it_can_create_and_update_bank_transactions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Reference' => 'BT-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BankTransactions' => [[
                'BankTransactionID' => 'bank-1',
                'Type' => 'SPEND',
                'Reference' => 'BT-1002',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->bankTransactions()->create()
            ->using(
                (new BankTransaction())
                    ->setType('SPEND')
                    ->setContact(
                        (new Contact())
                            ->setContactID('contact-1')
                    )
                    ->setBankAccount(
                        (new BankAccount())
                            ->setAccountID('account-1')
                    )
                    ->setReference('BT-1001')
                    ->addLineItem(
                        (new LineItem())
                            ->setDescription('Office supplies')
                            ->setQuantity(1)
                            ->setUnitAmount(25)
                    )
            )
            ->save();

        $updated = $created->reference('BT-1002')->save();

        $json0 = $transport->requests()[0]->json ?? [];
        $bt0 = Json::extractFirst($json0, 'BankTransactions');
        self::assertNotNull($bt0);
        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[0]->path);
        self::assertSame('SPEND', $bt0['Type']);
        self::assertSame('contact-1', Json::extractObject($bt0, 'Contact')['ContactID']);
        self::assertSame('account-1', Json::extractObject($bt0, 'BankAccount')['AccountID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $bt1 = Json::extractFirst($json1, 'BankTransactions');
        self::assertNotNull($bt1);
        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[1]->path);
        self::assertSame('bank-1', $bt1['BankTransactionID']);
        self::assertSame('BT-1002', $updated->getReference());
    }
}
