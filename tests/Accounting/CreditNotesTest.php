<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\CreditNote\CreditNote;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class CreditNotesTest extends TestCase
{
    public function test_it_can_query_and_find_credit_notes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Status' => 'AUTHORISED',
                'Reference' => 'CN-1001',
                'Contact' => [
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Pty Ltd',
                ],
                'LineItems' => [[
                    'Description' => 'Adjustment',
                    'Quantity' => 1,
                    'UnitAmount' => 50,
                ]],
                'Date' => '2026-03-25',
                'DueDate' => '2026-04-25',
                'LineAmountTypes' => 'Exclusive',
                'SubTotal' => 50,
                'TotalTax' => 5,
                'CISDeduction' => 1,
                'CISRate' => 0.2,
                'UpdatedDateUTC' => '2026-03-25T01:00:00',
                'CurrencyCode' => 'NZD',
                'FullyPaidOnDate' => '2026-04-01',
                'CreditNoteNumber' => 'CN-1001',
                'SentToContact' => true,
                'CurrencyRate' => 1.0,
                'RemainingCredit' => 10,
                'Allocations' => [['AllocationID' => 'allocation-1', 'Amount' => 5]],
                'AppliedAmount' => 40,
                'Payments' => [['PaymentID' => 'payment-1']],
                'BrandingThemeID' => 'theme-1',
                'StatusAttributeString' => 'OK',
                'HasAttachments' => true,
                'HasErrors' => false,
                'ValidationErrors' => [['Message' => 'Some error']],
                'Warnings' => [['Message' => 'Some warning']],
                'InvoiceAddresses' => [[
                    'InvoiceAddressType' => 'FROM',
                    'AddressLine1' => '1 Queen St',
                    'AddressLine2' => 'Level 2',
                    'AddressLine3' => 'Suite 3',
                    'AddressLine4' => 'Block 4',
                    'City' => 'Auckland',
                    'Region' => 'Auckland Region',
                    'PostalCode' => '1010',
                    'Country' => 'NZ',
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Status' => 'AUTHORISED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $creditNotes = $client->accounting()->creditNotes()->where('Status == :status', status: 'AUTHORISED')->get();
        $creditNote = $client->accounting()->creditNotes()->find('credit-1');

        self::assertSame('/api.xro/2.0/CreditNotes', $transport->requests()[0]->path);
        self::assertSame('Status == "AUTHORISED"', $transport->requests()[0]->query['where']);
        $firstCn = $creditNotes->first();
        self::assertNotNull($firstCn);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1', $transport->requests()[1]->path);
        self::assertSame('credit-1', $creditNote?->getCreditNoteID());
        self::assertSame('contact-1', $firstCn->getContact()?->getContactID());
        self::assertSame('Adjustment', $firstCn->getLineItems()[0]->getDescription());
        self::assertSame('2026-03-25', $firstCn->getDate());
        self::assertSame('2026-04-25', $firstCn->getDueDate());
        self::assertSame('Exclusive', $firstCn->getLineAmountTypes());
        self::assertSame(50, $firstCn->getSubTotal());
        self::assertSame(5, $firstCn->getTotalTax());
        self::assertSame(1, $firstCn->getCISDeduction());
        self::assertSame(0.2, $firstCn->getCISRate());
        self::assertSame('2026-03-25T01:00:00', $firstCn->getUpdatedDateUTC());
        self::assertSame('NZD', $firstCn->getCurrencyCode());
        self::assertSame('2026-04-01', $firstCn->getFullyPaidOnDate());
        self::assertSame('CN-1001', $firstCn->getCreditNoteNumber());
        self::assertTrue($firstCn->getSentToContact());
        self::assertSame(1, $firstCn->getCurrencyRate());
        self::assertSame(10, $firstCn->getRemainingCredit());
        self::assertCount(1, $firstCn->getAllocations());
        self::assertSame('allocation-1', $firstCn->getAllocations()[0]->getAllocationID());
        self::assertSame(40, $firstCn->getAppliedAmount());
        self::assertCount(1, $firstCn->getPayments());
        self::assertSame('payment-1', $firstCn->getPayments()[0]->getPaymentID());
        self::assertSame('theme-1', $firstCn->getBrandingThemeID());
        self::assertSame('OK', $firstCn->getStatusAttributeString());
        self::assertTrue($firstCn->getHasAttachments());
        self::assertFalse($firstCn->getHasErrors());
        self::assertCount(1, $firstCn->getValidationErrors());
        self::assertSame('Some error', $firstCn->getValidationErrors()[0]->getMessage());
        self::assertCount(1, $firstCn->getWarnings());
        self::assertSame('Some warning', $firstCn->getWarnings()[0]->getMessage());
        self::assertCount(1, $firstCn->getInvoiceAddresses());
        $invoiceAddress = $firstCn->getInvoiceAddresses()[0];
        self::assertSame('FROM', $invoiceAddress->getInvoiceAddressType());
        self::assertSame('1 Queen St', $invoiceAddress->getAddressLine1());
        self::assertSame('Level 2', $invoiceAddress->getAddressLine2());
        self::assertSame('Suite 3', $invoiceAddress->getAddressLine3());
        self::assertSame('Block 4', $invoiceAddress->getAddressLine4());
        self::assertSame('Auckland', $invoiceAddress->getCity());
        self::assertSame('Auckland Region', $invoiceAddress->getRegion());
        self::assertSame('1010', $invoiceAddress->getPostalCode());
        self::assertSame('NZ', $invoiceAddress->getCountry());
    }

    public function test_it_can_create_and_update_credit_notes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Reference' => 'CN-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [[
                'CreditNoteID' => 'credit-1',
                'Type' => 'ACCRECCREDIT',
                'Reference' => 'CN-1002',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->creditNotes()->create()
            ->using(
                (new CreditNote())
                    ->setType('ACCRECCREDIT')
                    ->setContact(
                        (new Contact())
                            ->setContactID('contact-1')
                    )
                    ->setReference('CN-1001')
                    ->addLineItem(
                        (new LineItem())
                            ->setDescription('Adjustment')
                            ->setQuantity(1)
                            ->setUnitAmount(50)
                    )
            )
            ->save();

        $updated = $created->reference('CN-1002')->save();

        self::assertSame('/api.xro/2.0/CreditNotes', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        $cn0 = Json::extractFirst($json0, 'CreditNotes');
        self::assertNotNull($cn0);
        self::assertSame('ACCRECCREDIT', $cn0['Type']);
        self::assertSame('contact-1', Json::extractObject($cn0, 'Contact')['ContactID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $cn1 = Json::extractFirst($json1, 'CreditNotes');
        self::assertNotNull($cn1);
        self::assertSame('/api.xro/2.0/CreditNotes', $transport->requests()[1]->path);
        self::assertSame('credit-1', $cn1['CreditNoteID']);
        self::assertSame('CN-1002', $updated->getReference());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.transactions.read', 'accounting.transactions'], $scopes->granular);
    }

    public function test_it_can_paginate_credit_notes(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['CreditNotes' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->paginate(page: 2, perPage: 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'CreditNotes' => [['CreditNoteID' => 'credit-1', 'Type' => 'ACCRECCREDIT']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->update('credit-1')
            ->type('accreccredit')
            ->contact('contact-1')
            ->reference('CN-3001')
            ->lineItem('Adjustment', 1, 50)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $cn = Json::extractFirst($json, 'CreditNotes');
        self::assertNotNull($cn);
        self::assertSame('credit-1', $cn['CreditNoteID']);
        self::assertSame('ACCRECCREDIT', $cn['Type']);
        self::assertSame('contact-1', Json::extractObject($cn, 'Contact')['ContactID']);
        self::assertSame('CN-3001', $cn['Reference']);
        $lineItems = Json::extractList($cn, 'LineItems');
        self::assertSame('Adjustment', $lineItems[0]['Description'] ?? null);
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $creditNote = (new CreditNote())
            ->type('accreccredit')
            ->contact('contact-9')
            ->lineItem('Refund', 1, 75)
            ->setTotal(75)
            ->setLineItems([
                (new LineItem())->setDescription('Replaced'),
            ]);

        self::assertSame('ACCRECCREDIT', $creditNote->getType());
        self::assertSame('contact-9', $creditNote->getContact()?->getContactID());
        self::assertSame(75, $creditNote->getTotal());
        self::assertSame('Replaced', $creditNote->getLineItems()[0]->getDescription());
    }

    public function test_bound_model_exposes_attachments_history_and_pdf(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'CreditNotes' => [['CreditNoteID' => 'credit-1']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-1.4 credit'));

        $creditNote = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->find('credit-1');

        self::assertNotNull($creditNote);
        $creditNote->attachments();
        $creditNote->history();
        $pdf = $creditNote->pdf();

        self::assertSame('%PDF-1.4 credit', $pdf);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-1/pdf', $transport->requests()[1]->path);
    }

    public function test_it_serializes_writable_credit_note_fields_to_request(): void
    {
        $creditNote = (new CreditNote())
            ->setDate('2026-03-25')
            ->setDueDate('2026-04-25')
            ->setLineAmountTypes('Exclusive')
            ->setCurrencyCode('NZD')
            ->setCurrencyRate(1.0)
            ->setCreditNoteNumber('CN-1001')
            ->setBrandingThemeID('theme-1')
            ->addInvoiceAddress(
                (new \Sujip\Xero\Support\InvoiceAddress())
                    ->setInvoiceAddressType('FROM')
                    ->setAddressLine1('1 Queen St')
                    ->setAddressLine2('Level 2')
                    ->setAddressLine3('Suite 3')
                    ->setAddressLine4('Block 4')
                    ->setCity('Auckland')
                    ->setRegion('Auckland Region')
                    ->setPostalCode('1010')
                    ->setCountry('NZ')
            );

        $request = $creditNote->toRequest();

        self::assertSame('2026-03-25', $request['Date']);
        self::assertSame('2026-04-25', $request['DueDate']);
        self::assertSame('Exclusive', $request['LineAmountTypes']);
        self::assertSame('NZD', $request['CurrencyCode']);
        self::assertSame(1.0, $request['CurrencyRate']);
        self::assertSame('CN-1001', $request['CreditNoteNumber']);
        self::assertSame('theme-1', $request['BrandingThemeID']);
        $invoiceAddress = Json::extractFirst($request, 'InvoiceAddresses') ?? [];
        self::assertSame('FROM', $invoiceAddress['InvoiceAddressType'] ?? null);
        self::assertSame('1 Queen St', $invoiceAddress['AddressLine1'] ?? null);
        self::assertSame('Level 2', $invoiceAddress['AddressLine2'] ?? null);
        self::assertSame('Suite 3', $invoiceAddress['AddressLine3'] ?? null);
        self::assertSame('Block 4', $invoiceAddress['AddressLine4'] ?? null);
        self::assertSame('Auckland', $invoiceAddress['City'] ?? null);
        self::assertSame('Auckland Region', $invoiceAddress['Region'] ?? null);
        self::assertSame('1010', $invoiceAddress['PostalCode'] ?? null);
        self::assertSame('NZ', $invoiceAddress['Country'] ?? null);
        self::assertArrayNotHasKey('SubTotal', $request);
        self::assertArrayNotHasKey('TotalTax', $request);
        self::assertArrayNotHasKey('CISDeduction', $request);
        self::assertArrayNotHasKey('CISRate', $request);
        self::assertArrayNotHasKey('UpdatedDateUTC', $request);
        self::assertArrayNotHasKey('SentToContact', $request);
        self::assertArrayNotHasKey('RemainingCredit', $request);
        self::assertArrayNotHasKey('Allocations', $request);
        self::assertArrayNotHasKey('AppliedAmount', $request);
        self::assertArrayNotHasKey('Payments', $request);
        self::assertArrayNotHasKey('StatusAttributeString', $request);
        self::assertArrayNotHasKey('HasAttachments', $request);
        self::assertArrayNotHasKey('HasErrors', $request);
        self::assertArrayNotHasKey('ValidationErrors', $request);
        self::assertArrayNotHasKey('Warnings', $request);
        self::assertArrayNotHasKey('FullyPaidOnDate', $request);
    }

    public function test_credit_note_setters_compose_remaining_fields(): void
    {
        $creditNote = (new CreditNote())
            ->setSubTotal(50)
            ->setTotalTax(5)
            ->setCISDeduction(1)
            ->setCISRate(0.2)
            ->setUpdatedDateUTC('2026-03-25T01:00:00')
            ->setFullyPaidOnDate('2026-04-01')
            ->setSentToContact(true)
            ->setRemainingCredit(10)
            ->setAppliedAmount(40)
            ->setStatusAttributeString('OK')
            ->setHasAttachments(true)
            ->setHasErrors(false);

        $creditNote->addAllocation((new \Sujip\Xero\Accounting\Allocation())->setAllocationID('allocation-1'));
        $creditNote->addPayment((new \Sujip\Xero\Accounting\Payment\Payment())->setPaymentID('payment-1'));
        $creditNote->addValidationError((new \Sujip\Xero\Support\ValidationError())->setMessage('Some error'));
        $creditNote->addWarning((new \Sujip\Xero\Support\ValidationError())->setMessage('Some warning'));

        self::assertSame(50, $creditNote->getSubTotal());
        self::assertSame(5, $creditNote->getTotalTax());
        self::assertSame(1, $creditNote->getCISDeduction());
        self::assertSame(0.2, $creditNote->getCISRate());
        self::assertSame('2026-03-25T01:00:00', $creditNote->getUpdatedDateUTC());
        self::assertSame('2026-04-01', $creditNote->getFullyPaidOnDate());
        self::assertTrue($creditNote->getSentToContact());
        self::assertSame(10, $creditNote->getRemainingCredit());
        self::assertSame(40, $creditNote->getAppliedAmount());
        self::assertSame('OK', $creditNote->getStatusAttributeString());
        self::assertTrue($creditNote->getHasAttachments());
        self::assertFalse($creditNote->getHasErrors());
        self::assertCount(1, $creditNote->getAllocations());
        self::assertSame('allocation-1', $creditNote->getAllocations()[0]->getAllocationID());
        self::assertCount(1, $creditNote->getPayments());
        self::assertSame('payment-1', $creditNote->getPayments()[0]->getPaymentID());
        self::assertCount(1, $creditNote->getValidationErrors());
        self::assertSame('Some error', $creditNote->getValidationErrors()[0]->getMessage());
        self::assertCount(1, $creditNote->getWarnings());
        self::assertSame('Some warning', $creditNote->getWarnings()[0]->getMessage());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->save();
    }

    public function test_attachments_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->attachments();
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->history();
    }

    public function test_pdf_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new CreditNote())->pdf();
    }
}
