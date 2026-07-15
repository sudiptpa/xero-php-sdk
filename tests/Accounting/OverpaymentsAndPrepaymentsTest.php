<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Overpayment\Overpayment;
use Sujip\Xero\Accounting\Prepayment\Prepayment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class OverpaymentsAndPrepaymentsTest extends TestCase
{
    public function test_it_can_query_and_find_overpayments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Overpayments' => [[
                'OverpaymentID' => 'over-1',
                'Type' => 'OVERPAYMENT',
                'Status' => 'AUTHORISED',
                'RemainingCredit' => 20,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Overpayments' => [[
                'OverpaymentID' => 'over-1',
                'Type' => 'RECEIVE-OVERPAYMENT',
                'Status' => 'AUTHORISED',
                'Contact' => ['ContactID' => 'contact-1'],
                'Date' => '2026-04-01T00:00:00',
                'LineAmountTypes' => 'Exclusive',
                'LineItems' => [['Description' => 'Overpayment line', 'Quantity' => 1, 'UnitAmount' => 20]],
                'SubTotal' => 20,
                'TotalTax' => 0,
                'Total' => 20,
                'UpdatedDateUTC' => '2026-04-01T01:00:00',
                'UpdatedDateUTCString' => '2026-04-01T01:00:00Z',
                'CurrencyCode' => 'NZD',
                'CurrencyRate' => 1.0,
                'RemainingCredit' => 20,
                'Allocations' => [['AllocationID' => 'alloc-1', 'Amount' => 5]],
                'AppliedAmount' => 5,
                'Payments' => [['PaymentID' => 'payment-1']],
                'HasAttachments' => true,
                'Reference' => 'REF-OP-1',
                'Attachments' => [['AttachmentID' => 'attach-1', 'FileName' => 'photo.jpg']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Overpayments' => [[
                'OverpaymentID' => 'over-1',
                'Type' => 'OVERPAYMENT',
                'Status' => 'AUTHORISED',
                'RemainingCredit' => 20,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $overpayments = $client->accounting()->overpayments()->where('Status == :status', status: 'AUTHORISED')->get();
        $overpayment = $client->accounting()->overpayments()->find('over-1');
        $page = $client->accounting()->overpayments()->paginate(1, 50);

        self::assertSame('/api.xro/2.0/Overpayments', $transport->requests()[0]->path);
        $first = $overpayments->first();
        self::assertInstanceOf(Overpayment::class, $first);
        self::assertSame('OVERPAYMENT', $first->getType());
        self::assertSame('AUTHORISED', $first->getStatus());
        self::assertSame(20, $first->getRemainingCredit());
        self::assertSame('/api.xro/2.0/Overpayments/over-1', $transport->requests()[1]->path);
        self::assertNotNull($overpayment);
        self::assertSame('over-1', $overpayment->getOverpaymentID());
        self::assertSame('RECEIVE-OVERPAYMENT', $overpayment->getType());
        self::assertSame('contact-1', $overpayment->getContact()?->getContactID());
        self::assertSame('2026-04-01T00:00:00', $overpayment->getDate());
        self::assertSame('Exclusive', $overpayment->getLineAmountTypes());
        self::assertCount(1, $overpayment->getLineItems());
        self::assertSame('Overpayment line', $overpayment->getLineItems()[0]->getDescription());
        self::assertSame(20, $overpayment->getSubTotal());
        self::assertSame(0, $overpayment->getTotalTax());
        self::assertSame(20, $overpayment->getTotal());
        self::assertSame('2026-04-01T01:00:00', $overpayment->getUpdatedDateUTC());
        self::assertSame('2026-04-01T01:00:00Z', $overpayment->getUpdatedDateUTCString());
        self::assertSame('NZD', $overpayment->getCurrencyCode());
        self::assertSame(1, $overpayment->getCurrencyRate());
        self::assertCount(1, $overpayment->getAllocations());
        self::assertSame('alloc-1', $overpayment->getAllocations()[0]->getAllocationID());
        self::assertSame(5, $overpayment->getAppliedAmount());
        self::assertCount(1, $overpayment->getPayments());
        self::assertSame('payment-1', $overpayment->getPayments()[0]->getPaymentID());
        self::assertTrue($overpayment->getHasAttachments());
        self::assertSame('REF-OP-1', $overpayment->getReference());
        self::assertCount(1, $overpayment->getAttachments());
        self::assertSame('attach-1', $overpayment->getAttachments()[0]->getAttachmentID());
        self::assertNotNull($page->items->first());
        self::assertSame(1, $page->page);
        self::assertNotSame([], $client->accounting()->overpayments()->scopes()->broad);
    }

    public function test_set_line_items_replaces_the_line_items_list(): void
    {
        $overpayment = (new Overpayment())
            ->addLineItem((new \Sujip\Xero\Accounting\Invoice\LineItem())->setDescription('First'))
            ->setLineItems([(new \Sujip\Xero\Accounting\Invoice\LineItem())->setDescription('Second')]);

        self::assertCount(1, $overpayment->getLineItems());
        self::assertSame('Second', $overpayment->getLineItems()[0]->getDescription());
    }

    public function test_it_can_query_and_find_prepayments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Prepayments' => [[
                'PrepaymentID' => 'pre-1',
                'Type' => 'PREPAYMENT',
                'Status' => 'AUTHORISED',
                'RemainingCredit' => 10,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Prepayments' => [[
                'PrepaymentID' => 'pre-1',
                'Type' => 'RECEIVE-PREPAYMENT',
                'Status' => 'AUTHORISED',
                'Contact' => ['ContactID' => 'contact-1'],
                'Date' => '2026-04-01T00:00:00',
                'LineAmountTypes' => 'Exclusive',
                'LineItems' => [['Description' => 'Prepayment line', 'Quantity' => 1, 'UnitAmount' => 10]],
                'SubTotal' => 10,
                'TotalTax' => 0,
                'Total' => 10,
                'Reference' => 'INV-PRE-1',
                'InvoiceNumber' => 'INV-PRE-1',
                'UpdatedDateUTC' => '2026-04-01T01:00:00',
                'UpdatedDateUTCString' => '2026-04-01T01:00:00Z',
                'CurrencyCode' => 'NZD',
                'BrandingThemeID' => 'brand-1',
                'CurrencyRate' => 1.0,
                'RemainingCredit' => 10,
                'Allocations' => [['AllocationID' => 'alloc-1', 'Amount' => 5]],
                'Payments' => [['PaymentID' => 'payment-1']],
                'AppliedAmount' => 5,
                'HasAttachments' => true,
                'Attachments' => [['AttachmentID' => 'attach-1', 'FileName' => 'photo.jpg']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Prepayments' => [[
                'PrepaymentID' => 'pre-1',
                'Type' => 'PREPAYMENT',
                'Status' => 'AUTHORISED',
                'RemainingCredit' => 10,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $prepayments = $client->accounting()->prepayments()->where('Status == :status', status: 'AUTHORISED')->get();
        $prepayment = $client->accounting()->prepayments()->find('pre-1');
        $page = $client->accounting()->prepayments()->paginate(1, 50);

        self::assertSame('/api.xro/2.0/Prepayments', $transport->requests()[0]->path);
        $first = $prepayments->first();
        self::assertInstanceOf(Prepayment::class, $first);
        self::assertSame('PREPAYMENT', $first->getType());
        self::assertSame('AUTHORISED', $first->getStatus());
        self::assertSame(10, $first->getRemainingCredit());
        self::assertSame('/api.xro/2.0/Prepayments/pre-1', $transport->requests()[1]->path);
        self::assertNotNull($prepayment);
        self::assertSame('pre-1', $prepayment->getPrepaymentID());
        self::assertSame('RECEIVE-PREPAYMENT', $prepayment->getType());
        self::assertSame('contact-1', $prepayment->getContact()?->getContactID());
        self::assertSame('2026-04-01T00:00:00', $prepayment->getDate());
        self::assertSame('Exclusive', $prepayment->getLineAmountTypes());
        self::assertCount(1, $prepayment->getLineItems());
        self::assertSame('Prepayment line', $prepayment->getLineItems()[0]->getDescription());
        self::assertSame(10, $prepayment->getSubTotal());
        self::assertSame(0, $prepayment->getTotalTax());
        self::assertSame(10, $prepayment->getTotal());
        self::assertSame('INV-PRE-1', $prepayment->getReference());
        self::assertSame('INV-PRE-1', $prepayment->getInvoiceNumber());
        self::assertSame('2026-04-01T01:00:00', $prepayment->getUpdatedDateUTC());
        self::assertSame('2026-04-01T01:00:00Z', $prepayment->getUpdatedDateUTCString());
        self::assertSame('NZD', $prepayment->getCurrencyCode());
        self::assertSame('brand-1', $prepayment->getBrandingThemeID());
        self::assertSame(1, $prepayment->getCurrencyRate());
        self::assertCount(1, $prepayment->getAllocations());
        self::assertSame('alloc-1', $prepayment->getAllocations()[0]->getAllocationID());
        self::assertCount(1, $prepayment->getPayments());
        self::assertSame('payment-1', $prepayment->getPayments()[0]->getPaymentID());
        self::assertSame(5, $prepayment->getAppliedAmount());
        self::assertTrue($prepayment->getHasAttachments());
        self::assertCount(1, $prepayment->getAttachments());
        self::assertSame('attach-1', $prepayment->getAttachments()[0]->getAttachmentID());
        self::assertNotNull($page->items->first());
        self::assertSame(1, $page->page);
        self::assertNotSame([], $client->accounting()->prepayments()->scopes()->broad);
    }

    public function test_set_prepayment_line_items_replaces_the_line_items_list(): void
    {
        $prepayment = (new Prepayment())
            ->addLineItem((new \Sujip\Xero\Accounting\Invoice\LineItem())->setDescription('First'))
            ->setLineItems([(new \Sujip\Xero\Accounting\Invoice\LineItem())->setDescription('Second')]);

        self::assertCount(1, $prepayment->getLineItems());
        self::assertSame('Second', $prepayment->getLineItems()[0]->getDescription());
    }
}
