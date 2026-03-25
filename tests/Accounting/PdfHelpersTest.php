<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class PdfHelpersTest extends TestCase
{
    public function test_it_can_fetch_invoice_pdf_from_resource_and_model(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '%PDF-invoice-direct'));
        $transport->push(new Response(200, body: json_encode([
            'Invoices' => [[
                'InvoiceID' => 'invoice-1',
                'Reference' => 'INV-1',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-invoice-model'));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $pdf = $client->accounting()->invoices()->pdf('invoice-1');
        $invoice = $client->accounting()->invoices()->find('invoice-1');
        $modelPdf = $invoice?->pdf();

        self::assertSame('/api.xro/2.0/Invoices/invoice-1/pdf', $transport->requests()[0]->path);
        self::assertSame('application/pdf', $transport->requests()[0]->headers['Accept']);
        self::assertSame('%PDF-invoice-direct', $pdf);
        self::assertSame('/api.xro/2.0/Invoices/invoice-1/pdf', $transport->requests()[2]->path);
        self::assertSame('%PDF-invoice-model', $modelPdf);
    }

    public function test_it_can_fetch_quote_pdf_from_resource_and_model(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '%PDF-quote-direct'));
        $transport->push(new Response(200, body: json_encode([
            'Quotes' => [[
                'QuoteID' => 'quote-1',
                'Title' => 'Website redesign',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-quote-model'));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $pdf = $client->accounting()->quotes()->pdf('quote-1');
        $quote = $client->accounting()->quotes()->find('quote-1');
        $modelPdf = $quote?->pdf();

        self::assertSame('/api.xro/2.0/Quotes/quote-1/pdf', $transport->requests()[0]->path);
        self::assertSame('%PDF-quote-direct', $pdf);
        self::assertSame('/api.xro/2.0/Quotes/quote-1/pdf', $transport->requests()[2]->path);
        self::assertSame('%PDF-quote-model', $modelPdf);
    }
}
