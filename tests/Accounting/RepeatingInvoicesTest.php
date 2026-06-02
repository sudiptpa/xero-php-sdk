<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class RepeatingInvoicesTest extends TestCase
{
    public function test_it_can_query_and_find_repeating_invoices(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Type' => 'ACCREC',
                'Status' => 'DRAFT',
                'Reference' => 'RI-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Type' => 'ACCREC',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $repeatingInvoices = $client->accounting()->repeatingInvoices()->where('Status == :status', status: 'DRAFT')->get();
        $repeatingInvoice = $client->accounting()->repeatingInvoices()->find('repeat-1');

        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[0]->path);
        self::assertNotNull($repeatingInvoices->first());
        self::assertSame('/api.xro/2.0/RepeatingInvoices/repeat-1', $transport->requests()[1]->path);
        self::assertSame('repeat-1', $repeatingInvoice?->getRepeatingInvoiceID());
    }

    public function test_it_can_create_and_update_repeating_invoices(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Reference' => 'RI-1001',
                'Type' => 'ACCREC',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Reference' => 'RI-1002',
                'Type' => 'ACCREC',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->repeatingInvoices()->create()
            ->type('ACCREC')
            ->contact('contact-1')
            ->reference('RI-1001')
            ->lineItem('Monthly support', 1, 99)
            ->save();

        $updated = $created->reference('RI-1002')->save();

        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        $ri0 = Json::extractFirst($json0, 'RepeatingInvoices');
        self::assertNotNull($ri0);
        self::assertSame('contact-1', Json::extractObject($ri0, 'Contact')['ContactID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $ri1 = Json::extractFirst($json1, 'RepeatingInvoices');
        self::assertNotNull($ri1);
        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[1]->path);
        self::assertSame('repeat-1', $ri1['RepeatingInvoiceID']);
        self::assertSame('RI-1002', $updated->getReference());
    }
}
