<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\Invoice;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class InvoicesTest extends TestCase
{
    public function test_it_builds_a_fluent_invoice_draft_payload(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Invoices' => [[
                    'InvoiceID' => 'invoice-1',
                    'Type' => 'ACCREC',
                    'Status' => 'DRAFT',
                    'Reference' => 'PO-1001',
                    'LineItems' => [[
                        'Description' => 'Consulting',
                        'Quantity' => 2,
                        'UnitAmount' => 150,
                    ]],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->create()
            ->using(
                (new Invoice())
                    ->setType('ACCREC')
                    ->setStatus('DRAFT')
                    ->setContact(
                        (new Contact())
                            ->setContactID('contact-1')
                            ->setName('Acme Pty Ltd')
                    )
                    ->setReference('PO-1001')
                    ->addLineItem(
                        (new LineItem())
                            ->setDescription('Consulting')
                            ->setQuantity(2)
                            ->setUnitAmount(150)
                    )
            )
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Invoices', $request->path);
        self::assertSame('ACCREC', $request->json['Invoices'][0]['Type']);
        self::assertSame('DRAFT', $request->json['Invoices'][0]['Status']);
        self::assertSame('contact-1', $request->json['Invoices'][0]['Contact']['ContactID']);
        self::assertSame('Acme Pty Ltd', $request->json['Invoices'][0]['Contact']['Name']);
        self::assertSame('PO-1001', $invoice->getReference());
        self::assertCount(1, $invoice->getLineItems());
    }

    public function test_it_can_query_invoices(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Invoices' => [[
                    'InvoiceID' => 'invoice-1',
                    'Type' => 'ACCREC',
                    'Status' => 'AUTHORISED',
                    'Reference' => 'PO-1001',
                    'Contact' => [
                        'ContactID' => 'contact-1',
                        'Name' => 'Acme Pty Ltd',
                    ],
                    'LineItems' => [],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $invoices = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->where('Status == :status', status: 'AUTHORISED')
            ->orderBy('UpdatedDateUTC', 'DESC')
            ->page(1)
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Invoices', $request->path);
        self::assertSame('Status == "AUTHORISED"', $request->query['where']);
        self::assertSame('UpdatedDateUTC DESC', $request->query['order']);
        self::assertSame('AUTHORISED', $invoices->first()->getStatus());
        self::assertSame('contact-1', $invoices->first()->getContact()->getContactID());
        self::assertSame('Acme Pty Ltd', $invoices->first()->getContact()->getName());
    }

    public function test_it_can_find_an_invoice(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Invoices' => [[
                    'InvoiceID' => 'invoice-1',
                    'Type' => 'ACCPAY',
                    'Status' => 'PAID',
                    'Reference' => 'BILL-1001',
                    'LineItems' => [],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->find('invoice-1');

        self::assertSame('invoice-1', $invoice->getInvoiceID());
        self::assertSame('ACCPAY', $invoice->getType());
    }

    public function test_it_can_update_an_invoice(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Invoices' => [[
                    'InvoiceID' => 'invoice-1',
                    'Type' => 'ACCREC',
                    'Status' => 'DRAFT',
                    'Reference' => 'PO-1002',
                    'LineItems' => [],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->update('invoice-1')
            ->reference('PO-1002')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Invoices/invoice-1', $request->path);
        self::assertSame('PO-1002', $invoice->getReference());
    }

    public function test_loaded_invoice_can_be_changed_and_saved_fluently(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Invoices' => [[
                'InvoiceID' => 'invoice-1',
                'Type' => 'ACCREC',
                'Status' => 'DRAFT',
                'Reference' => 'PO-1001',
                'LineItems' => [],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Invoices' => [[
                'InvoiceID' => 'invoice-1',
                'Type' => 'ACCREC',
                'Status' => 'DRAFT',
                'Reference' => 'PO-2001',
                'LineItems' => [],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->find('invoice-1');

        $saved = $invoice?->reference('PO-2001')->save();

        $request = $transport->requests()[1];

        self::assertSame('/api.xro/2.0/Invoices/invoice-1', $request->path);
        self::assertSame('PO-2001', $saved?->getReference());
    }
}
