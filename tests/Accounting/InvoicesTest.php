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
                    'Date' => '2026-01-01T00:00:00',
                    'DueDate' => '2026-01-31T00:00:00',
                    'LineAmountTypes' => 'Exclusive',
                    'InvoiceNumber' => 'INV-0001',
                    'BrandingThemeID' => 'theme-1',
                    'Url' => 'https://example.test/invoice',
                    'CurrencyCode' => 'NZD',
                    'CurrencyRate' => 1.5,
                    'SentToContact' => true,
                    'ExpectedPaymentDate' => '2026-02-01T00:00:00',
                    'PlannedPaymentDate' => '2026-02-02T00:00:00',
                    'CISDeduction' => 10.5,
                    'CISRate' => 0.25,
                    'SubTotal' => 100.5,
                    'TotalTax' => 15.25,
                    'Total' => 115.75,
                    'TotalDiscount' => 5.25,
                    'RepeatingInvoiceID' => 'repeating-1',
                    'HasAttachments' => true,
                    'IsDiscounted' => true,
                    'Payments' => [['PaymentID' => 'payment-1']],
                    'Prepayments' => [['PrepaymentID' => 'prepayment-1']],
                    'Overpayments' => [['OverpaymentID' => 'overpayment-1']],
                    'AmountDue' => 50.25,
                    'AmountPaid' => 65.75,
                    'FullyPaidOnDate' => '2026-02-03T00:00:00',
                    'AmountCredited' => 0.01,
                    'UpdatedDateUTC' => '2026-01-02T00:00:00',
                    'CreditNotes' => [['CreditNoteID' => 'credit-note-1']],
                    'Attachments' => [['AttachmentID' => 'attachment-1', 'FileName' => 'receipt.pdf']],
                    'HasErrors' => false,
                    'StatusAttributeString' => 'OK',
                    'ValidationErrors' => [['Message' => 'something went wrong']],
                    'Warnings' => [['Message' => 'a warning']],
                    'InvoiceAddresses' => [['InvoiceAddressType' => 'POBOX', 'City' => 'Auckland']],
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
        self::assertSame('2026-01-01T00:00:00', $invoice->getDate());
        self::assertSame('2026-01-31T00:00:00', $invoice->getDueDate());
        self::assertSame('Exclusive', $invoice->getLineAmountTypes());
        self::assertSame('INV-0001', $invoice->getInvoiceNumber());
        self::assertSame('theme-1', $invoice->getBrandingThemeID());
        self::assertSame('https://example.test/invoice', $invoice->getUrl());
        self::assertSame('NZD', $invoice->getCurrencyCode());
        self::assertSame(1.5, $invoice->getCurrencyRate());
        self::assertTrue($invoice->getSentToContact());
        self::assertSame('2026-02-01T00:00:00', $invoice->getExpectedPaymentDate());
        self::assertSame('2026-02-02T00:00:00', $invoice->getPlannedPaymentDate());
        self::assertSame(10.5, $invoice->getCISDeduction());
        self::assertSame(0.25, $invoice->getCISRate());
        self::assertSame(100.5, $invoice->getSubTotal());
        self::assertSame(15.25, $invoice->getTotalTax());
        self::assertSame(115.75, $invoice->getTotal());
        self::assertSame(5.25, $invoice->getTotalDiscount());
        self::assertSame('repeating-1', $invoice->getRepeatingInvoiceID());
        self::assertTrue($invoice->getHasAttachments());
        self::assertTrue($invoice->getIsDiscounted());
        self::assertSame(50.25, $invoice->getAmountDue());
        self::assertSame(65.75, $invoice->getAmountPaid());
        self::assertSame('2026-02-03T00:00:00', $invoice->getFullyPaidOnDate());
        self::assertSame(0.01, $invoice->getAmountCredited());
        self::assertSame('2026-01-02T00:00:00', $invoice->getUpdatedDateUTC());
        self::assertFalse($invoice->getHasErrors());
        self::assertSame('OK', $invoice->getStatusAttributeString());

        $payments = $invoice->getPayments();
        self::assertCount(1, $payments);
        self::assertSame('payment-1', $payments[0]->getPaymentID());

        $prepayments = $invoice->getPrepayments();
        self::assertCount(1, $prepayments);
        self::assertSame('prepayment-1', $prepayments[0]->getPrepaymentID());

        $overpayments = $invoice->getOverpayments();
        self::assertCount(1, $overpayments);
        self::assertSame('overpayment-1', $overpayments[0]->getOverpaymentID());

        $creditNotes = $invoice->getCreditNotes();
        self::assertCount(1, $creditNotes);
        self::assertSame('credit-note-1', $creditNotes[0]->getCreditNoteID());

        $attachments = $invoice->getAttachments();
        self::assertCount(1, $attachments);
        self::assertSame('attachment-1', $attachments[0]->getAttachmentID());
        self::assertSame('receipt.pdf', $attachments[0]->getFileName());

        $validationErrors = $invoice->getValidationErrors();
        self::assertCount(1, $validationErrors);
        self::assertSame('something went wrong', $validationErrors[0]->getMessage());

        $warnings = $invoice->getWarnings();
        self::assertCount(1, $warnings);
        self::assertSame('a warning', $warnings[0]->getMessage());

        $invoiceAddresses = $invoice->getInvoiceAddresses();
        self::assertCount(1, $invoiceAddresses);
        self::assertSame('POBOX', $invoiceAddresses[0]->getInvoiceAddressType());
        self::assertSame('Auckland', $invoiceAddresses[0]->getCity());
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

    public function test_it_can_email_an_invoice(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Invoices' => [['InvoiceID' => 'invoice-1', 'LineItems' => []]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204, body: ''));

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->find('invoice-1');

        self::assertNotNull($invoice);
        $invoice->email('email-key');

        $request = $transport->requests()[1];
        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Invoices/invoice-1/Email', $request->path);
        self::assertSame('{}', $request->body);
        self::assertSame('application/json', $request->headers['Content-Type']);
        self::assertSame('email-key', $request->headers['Idempotency-Key']);
    }

    public function test_it_can_email_an_invoice_without_an_idempotency_key(): void
    {
        $transport = (new FakeTransport())->push(new Response(204, body: ''));

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->email('invoice-1');

        self::assertArrayNotHasKey('Idempotency-Key', $transport->requests()[0]->headers);
    }

    public function test_it_can_fetch_the_online_invoice_url(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Invoices' => [['InvoiceID' => 'invoice-1', 'LineItems' => []]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'OnlineInvoices' => [['OnlineInvoiceUrl' => 'https://in.xero.com/abc123']],
        ], JSON_THROW_ON_ERROR)));

        $invoice = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->find('invoice-1');

        self::assertNotNull($invoice);
        self::assertSame('https://in.xero.com/abc123', $invoice->onlineInvoiceUrl());
        self::assertSame('/api.xro/2.0/Invoices/invoice-1/OnlineInvoice', $transport->requests()[1]->path);
    }

    public function test_online_invoice_url_is_null_when_absent(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $url = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->invoices()
            ->onlineInvoiceUrl('invoice-1');

        self::assertNull($url);
    }

    public function test_email_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Invoice())->email();
    }

    public function test_online_invoice_url_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Invoice())->onlineInvoiceUrl();
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
