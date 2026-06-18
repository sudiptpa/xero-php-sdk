<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Allocation;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class AllocationsTest extends TestCase
{
    public function test_it_creates_a_credit_note_allocation(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Allocations' => [[
                'AllocationID' => 'allocation-1',
                'Amount' => 25.5,
                'Date' => '/Date(1551744000000+0000)/',
                'Invoice' => ['InvoiceID' => 'invoice-1', 'LineItems' => []],
                'Overpayment' => ['OverpaymentID' => 'overpayment-1'],
                'Prepayment' => ['PrepaymentID' => 'prepayment-1'],
                'CreditNote' => ['CreditNoteID' => 'credit-note-1'],
                'StatusAttributeString' => 'ERROR',
                'ValidationErrors' => [['Message' => 'Invalid allocation amount']],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $allocation = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->allocations('credit-note-1')
            ->create('invoice-1', 25.5, '2019-03-05', 'alloc-key');

        $request = $transport->requests()[0];
        self::assertSame('PUT', $request->method);
        self::assertSame('/api.xro/2.0/CreditNotes/credit-note-1/Allocations', $request->path);
        self::assertSame('alloc-key', $request->headers['Idempotency-Key']);
        self::assertSame([
            'Allocations' => [[
                'Invoice' => ['InvoiceID' => 'invoice-1'],
                'Amount' => 25.5,
                'Date' => '2019-03-05',
            ]],
        ], $request->json);

        self::assertSame('allocation-1', $allocation->getAllocationID());
        self::assertSame(25.5, $allocation->getAmount());
        self::assertSame('/Date(1551744000000+0000)/', $allocation->getDate());
        $invoice = $allocation->getInvoice();
        self::assertNotNull($invoice);
        self::assertSame('invoice-1', $invoice->getInvoiceID());
        self::assertSame('overpayment-1', $allocation->getOverpayment()?->getOverpaymentID());
        self::assertSame('prepayment-1', $allocation->getPrepayment()?->getPrepaymentID());
        self::assertSame('credit-note-1', $allocation->getCreditNote()?->getCreditNoteID());
        self::assertSame('ERROR', $allocation->getStatusAttributeString());
        self::assertSame('Invalid allocation amount', $allocation->getValidationErrors()[0]->getMessage());
    }

    public function test_it_creates_an_overpayment_allocation_without_an_idempotency_key(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $allocation = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->overpayments()
            ->allocations('overpayment-1')
            ->create('invoice-1', 10.0, '2019-03-05');

        $request = $transport->requests()[0];
        self::assertSame('/api.xro/2.0/Overpayments/overpayment-1/Allocations', $request->path);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertNull($allocation->getAllocationID());
    }

    public function test_it_deletes_a_prepayment_allocation(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'AllocationID' => 'allocation-1',
            'Date' => '/Date(1551822670731)/',
            'IsDeleted' => true,
        ], JSON_THROW_ON_ERROR)));

        $allocation = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->prepayments()
            ->allocations('prepayment-1')
            ->delete('allocation-1');

        $request = $transport->requests()[0];
        self::assertSame('DELETE', $request->method);
        self::assertSame('/api.xro/2.0/Prepayments/prepayment-1/Allocations/allocation-1', $request->path);
        self::assertSame('allocation-1', $allocation->getAllocationID());
        self::assertTrue($allocation->getIsDeleted());
    }

    public function test_delete_handles_a_wrapped_allocations_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Allocations' => [['AllocationID' => 'allocation-2', 'IsDeleted' => true]],
        ], JSON_THROW_ON_ERROR)));

        $allocation = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->creditNotes()
            ->allocations('credit-note-1')
            ->delete('allocation-2');

        self::assertSame('allocation-2', $allocation->getAllocationID());
    }

    public function test_allocation_model_setters(): void
    {
        $allocation = (new Allocation())
            ->setAmount(99.5)
            ->setDate('2020-01-01')
            ->setIsDeleted(false)
            ->setInvoice(null);

        self::assertSame(99.5, $allocation->getAmount());
        self::assertSame('2020-01-01', $allocation->getDate());
        self::assertFalse($allocation->getIsDeleted());
        self::assertNull($allocation->getInvoice());
    }
}
