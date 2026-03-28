<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
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
        self::assertInstanceOf(RepeatingInvoice::class, $repeatingInvoices->first());
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
        self::assertSame('contact-1', $transport->requests()[0]->json['RepeatingInvoices'][0]['Contact']['ContactID']);
        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[1]->path);
        self::assertSame('repeat-1', $transport->requests()[1]->json['RepeatingInvoices'][0]['RepeatingInvoiceID']);
        self::assertSame('RI-1002', $updated->getReference());
    }
}
