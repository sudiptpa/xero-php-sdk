<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class InvoiceHistoryTest extends TestCase
{
    public function test_it_can_list_invoice_history(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'HistoryRecords' => [[
                    'Details' => 'Invoice viewed',
                    'User' => 'API',
                    'DateUTC' => '2026-03-25T00:00:00',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $history = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->history('invoice-1')
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Invoices/invoice-1/History', $request->path);
        self::assertNotNull($history->first());
    }

    public function test_it_can_record_invoice_history(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'HistoryRecords' => [[
                    'Details' => 'Invoice synced from back office',
                    'User' => 'API',
                    'DateUTC' => '2026-03-25T00:00:00',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $history = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->history('invoice-1')
            ->record('Invoice synced from back office');

        $request = $transport->requests()[0];

        self::assertSame('PUT', $request->method);
        self::assertSame('/api.xro/2.0/Invoices/invoice-1/History', $request->path);
        $json = $request->json ?? [];
        $hr = Json::extractFirst($json, 'HistoryRecords');
        self::assertNotNull($hr);
        self::assertSame('Invoice synced from back office', $hr['Details']);
        self::assertSame('Invoice synced from back office', $history->details);
    }
}
