<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\BankTransfer\BankTransfer;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
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
                'Amount' => 350.25,
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
        self::assertInstanceOf(BankTransfer::class, $transfers->first());
        self::assertSame('/api.xro/2.0/BankTransfers/transfer-1', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/BankTransfers', $transport->requests()[2]->path);
        self::assertSame('bank-a', $transport->requests()[2]->json['BankTransfers'][0]['FromBankAccount']['AccountID']);
        self::assertSame('Sweep', $created->getReference());
    }
}
