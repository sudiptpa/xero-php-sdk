<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\BankTransaction\BankTransaction;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
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

        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[0]->path);
        self::assertSame('Status == "AUTHORISED"', $transport->requests()[0]->query['where']);
        self::assertInstanceOf(BankTransaction::class, $transactions->first());
        self::assertSame('/api.xro/2.0/BankTransactions/bank-1', $transport->requests()[1]->path);
        self::assertSame('bank-1', $transaction?->id);
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
            ->type('SPEND')
            ->contact('contact-1')
            ->bankAccount('account-1')
            ->reference('BT-1001')
            ->lineItem('Office supplies', 1, 25)
            ->save();

        $updated = $created->reference('BT-1002')->save();

        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[0]->path);
        self::assertSame('SPEND', $transport->requests()[0]->json['BankTransactions'][0]['Type']);
        self::assertSame('/api.xro/2.0/BankTransactions', $transport->requests()[1]->path);
        self::assertSame('bank-1', $transport->requests()[1]->json['BankTransactions'][0]['BankTransactionID']);
        self::assertSame('BT-1002', $updated->reference);
    }
}
