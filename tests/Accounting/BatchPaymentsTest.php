<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\BatchPayment\BatchPayment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class BatchPaymentsTest extends TestCase
{
    public function test_it_can_query_and_find_batch_payments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BatchPayments' => [[
                'BatchPaymentID' => 'batch-1',
                'Reference' => 'BATCH-1001',
                'Status' => 'AUTHORISED',
                'Amount' => 75,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BatchPayments' => [[
                'BatchPaymentID' => 'batch-1',
                'Reference' => 'BATCH-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $batchPayments = $client->accounting()->batchPayments()->where('Status == :status', status: 'AUTHORISED')->get();
        $batchPayment = $client->accounting()->batchPayments()->find('batch-1');

        self::assertSame('/api.xro/2.0/BatchPayments', $transport->requests()[0]->path);
        self::assertInstanceOf(BatchPayment::class, $batchPayments->first());
        self::assertSame('/api.xro/2.0/BatchPayments/batch-1', $transport->requests()[1]->path);
        self::assertSame('batch-1', $batchPayment?->id);
    }

    public function test_it_can_create_batch_payments(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'BatchPayments' => [[
                    'BatchPaymentID' => 'batch-1',
                    'Reference' => 'BATCH-1001',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $batchPayment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->batchPayments()
            ->create()
            ->account('account-1')
            ->reference('BATCH-1001')
            ->payment('invoice-1', 75)
            ->save();

        self::assertSame('/api.xro/2.0/BatchPayments', $transport->requests()[0]->path);
        self::assertSame('account-1', $transport->requests()[0]->json['BatchPayments'][0]['Account']['AccountID']);
        self::assertSame('invoice-1', $transport->requests()[0]->json['BatchPayments'][0]['Payments'][0]['Invoice']['InvoiceID']);
        self::assertSame('batch-1', $batchPayment->id);
    }
}
