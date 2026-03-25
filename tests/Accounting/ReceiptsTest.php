<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Receipt\Receipt;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ReceiptsTest extends TestCase
{
    public function test_it_can_query_and_find_receipts(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-1',
                'ReceiptNumber' => 'REC-1001',
                'Status' => 'DRAFT',
                'Total' => 45,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Receipts' => [[
                'ReceiptID' => 'receipt-1',
                'ReceiptNumber' => 'REC-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $receipts = $client->accounting()->receipts()->where('Status == :status', status: 'DRAFT')->unitDp(4)->get();
        $receipt = $client->accounting()->receipts()->find('receipt-1');

        self::assertSame('/api.xro/2.0/Receipts', $transport->requests()[0]->path);
        self::assertSame(4, $transport->requests()[0]->query['unitdp']);
        self::assertInstanceOf(Receipt::class, $receipts->first());
        self::assertSame('/api.xro/2.0/Receipts/receipt-1', $transport->requests()[1]->path);
        self::assertSame('receipt-1', $receipt?->id);
    }
}
