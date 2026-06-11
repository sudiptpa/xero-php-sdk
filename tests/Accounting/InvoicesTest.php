<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\Invoice;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
        $json = $request->json ?? [];
        $inv = Json::extractFirst($json, 'Invoices');
        self::assertNotNull($inv);
        self::assertSame('ACCREC', $inv['Type']);
        self::assertSame('DRAFT', $inv['Status']);
        self::assertSame('contact-1', Json::extractObject($inv, 'Contact')['ContactID']);
        self::assertSame('Acme Pty Ltd', Json::extractObject($inv, 'Contact')['Name']);
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
        $firstInv = $invoices->first();
        self::assertNotNull($firstInv);
        self::assertSame('AUTHORISED', $firstInv->getStatus());
        $contact = $firstInv->getContact();
        self::assertNotNull($contact);
        self::assertSame('contact-1', $contact->getContactID());
        self::assertSame('Acme Pty Ltd', $contact->getName());
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

        self::assertNotNull($invoice);
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

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->invoices();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.invoices.read', 'accounting.invoices'], $scopes->granular);
    }

    public function test_it_can_paginate_invoices(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['Invoices' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->paginate(page: 4, perPage: 10);

        self::assertSame(4, $transport->requests()[0]->query['page']);
        self::assertSame(10, $transport->requests()[0]->query['pageSize']);
        self::assertSame(4, $page->page);
        self::assertSame(10, $page->perPage);
    }

    public function test_it_maps_line_items_directly(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->invoices();

        $lineItem = $resource->mapLineItem([
            'Description' => 'Consulting',
            'Quantity' => 2,
            'UnitAmount' => 150,
        ]);

        self::assertSame('Consulting', $lineItem->getDescription());
    }

    public function test_draft_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Invoices' => [['InvoiceID' => 'invoice-1', 'Status' => 'DRAFT']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->create()
            ->draft()
            ->contact('contact-1')
            ->type('accpay')
            ->reference('BILL-9001')
            ->lineItem('Consulting', 2, 150)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $inv = Json::extractFirst($json, 'Invoices');
        self::assertNotNull($inv);
        self::assertSame('DRAFT', $inv['Status']);
        self::assertSame('ACCPAY', $inv['Type']);
        self::assertSame('contact-1', Json::extractObject($inv, 'Contact')['ContactID']);
        self::assertSame('BILL-9001', $inv['Reference']);
        $lineItems = Json::extractList($inv, 'LineItems');
        self::assertSame('Consulting', $lineItems[0]['Description'] ?? null);
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $invoice = (new Invoice())
            ->type('accrec')
            ->draft()
            ->setContactID('contact-9')
            ->lineItem('Consulting', 1, 100)
            ->setLineItems([
                (new LineItem())->setDescription('Replaced'),
            ]);

        self::assertSame('ACCREC', $invoice->getType());
        self::assertSame('DRAFT', $invoice->getStatus());
        self::assertSame('contact-9', $invoice->getContactID());
        self::assertSame('Replaced', $invoice->getLineItems()[0]->getDescription());
    }

    public function test_bound_model_exposes_attachments_history_and_pdf(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Invoices' => [['InvoiceID' => 'invoice-1', 'LineItems' => []]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-1.4 invoice'));

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->find('invoice-1');

        self::assertNotNull($invoice);
        $invoice->attachments();
        $invoice->history();
        $pdf = $invoice->pdf();

        self::assertSame('%PDF-1.4 invoice', $pdf);
        self::assertSame('/api.xro/2.0/Invoices/invoice-1/pdf', $transport->requests()[1]->path);
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Invoice())->save();
    }

    public function test_attachments_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Invoice())->attachments();
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Invoice())->history();
    }

    public function test_pdf_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Invoice())->pdf();
    }
}
