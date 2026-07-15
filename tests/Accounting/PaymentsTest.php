<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Accounting\Payment\InvoiceReference;
use Sujip\Xero\Accounting\Payment\Payment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class PaymentsTest extends TestCase
{
    public function test_it_can_query_payments(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Payments' => [[
                    'PaymentID' => 'payment-1',
                    'Amount' => 150,
                    'Date' => '2026-03-25',
                    'Account' => [
                        'AccountID' => 'account-1',
                    ],
                    'CreditNote' => ['CreditNoteID' => 'creditnote-1'],
                    'Prepayment' => ['PrepaymentID' => 'prepayment-1'],
                    'Overpayment' => ['OverpaymentID' => 'overpayment-1'],
                    'InvoiceNumber' => 'INV-1001',
                    'CreditNoteNumber' => 'CN-1001',
                    'BatchPayment' => ['BatchPaymentID' => 'batch-1'],
                    'BatchPaymentID' => 'batch-1',
                    'Code' => '001',
                    'CurrencyRate' => 1.0,
                    'BankAmount' => 150,
                    'IsReconciled' => true,
                    'Status' => 'AUTHORISED',
                    'PaymentType' => 'ACCRECPAYMENT',
                    'UpdatedDateUTC' => '2026-03-25T01:00:00',
                    'UpdatedDateUTCString' => '2026-03-25T01:00:00Z',
                    'BankAccountNumber' => '123-456',
                    'Particulars' => 'particulars',
                    'Details' => 'details',
                    'HasAccount' => true,
                    'HasValidationErrors' => false,
                    'StatusAttributeString' => 'OK',
                    'ValidationErrors' => [['Message' => 'Some error']],
                    'Warnings' => [['Message' => 'Some warning']],
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $payments = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->payments()
            ->where('Amount == :amount', amount: 150)
            ->page(1)
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Payments', $request->path);
        self::assertSame('Amount == 150', $request->query['where']);
        $firstPayment = $payments->first();
        self::assertNotNull($firstPayment);
        self::assertSame(150.0, $firstPayment->getAmount());
        self::assertSame('account-1', $firstPayment->getAccount()?->getAccountID());
        self::assertSame('creditnote-1', $firstPayment->getCreditNote()?->getCreditNoteID());
        self::assertSame('prepayment-1', $firstPayment->getPrepayment()?->getPrepaymentID());
        self::assertSame('overpayment-1', $firstPayment->getOverpayment()?->getOverpaymentID());
        self::assertSame('INV-1001', $firstPayment->getInvoiceNumber());
        self::assertSame('CN-1001', $firstPayment->getCreditNoteNumber());
        self::assertSame('batch-1', $firstPayment->getBatchPayment()?->getBatchPaymentID());
        self::assertSame('batch-1', $firstPayment->getBatchPaymentID());
        self::assertSame('001', $firstPayment->getCode());
        self::assertSame(1, $firstPayment->getCurrencyRate());
        self::assertSame(150, $firstPayment->getBankAmount());
        self::assertTrue($firstPayment->getIsReconciled());
        self::assertSame('AUTHORISED', $firstPayment->getStatus());
        self::assertSame('ACCRECPAYMENT', $firstPayment->getPaymentType());
        self::assertSame('2026-03-25T01:00:00', $firstPayment->getUpdatedDateUTC());
        self::assertSame('2026-03-25T01:00:00Z', $firstPayment->getUpdatedDateUTCString());
        self::assertSame('123-456', $firstPayment->getBankAccountNumber());
        self::assertSame('particulars', $firstPayment->getParticulars());
        self::assertSame('details', $firstPayment->getDetails());
        self::assertTrue($firstPayment->getHasAccount());
        self::assertFalse($firstPayment->getHasValidationErrors());
        self::assertSame('OK', $firstPayment->getStatusAttributeString());
        self::assertCount(1, $firstPayment->getValidationErrors());
        self::assertSame('Some error', $firstPayment->getValidationErrors()[0]->getMessage());
        self::assertCount(1, $firstPayment->getWarnings());
        self::assertSame('Some warning', $firstPayment->getWarnings()[0]->getMessage());
    }

    public function test_it_can_create_a_payment_with_a_nested_account(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Payments' => [[
                    'PaymentID' => 'payment-1',
                    'Amount' => 150,
                    'Date' => '2026-03-25',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $payment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->payments()
            ->create()
            ->using(
                (new Payment())
                    ->setInvoiceID('invoice-1')
                    ->setAccount(
                        (new Account())
                            ->setAccountID('account-1')
                    )
                    ->setDate('2026-03-25')
                    ->setAmount(150)
                    ->setReference('PAY-1001')
            )
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Payments', $request->path);
        $json = $request->json ?? [];
        $pay = Json::extractFirst($json, 'Payments');
        self::assertNotNull($pay);
        self::assertSame('invoice-1', Json::extractObject($pay, 'Invoice')['InvoiceID']);
        self::assertSame('account-1', Json::extractObject($pay, 'Account')['AccountID']);
        self::assertSame(150.0, $payment->getAmount());
    }

    public function test_it_can_update_a_payment(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Payments' => [[
                    'PaymentID' => 'payment-1',
                    'Amount' => 150,
                    'Date' => '2026-03-25',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $payment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->payments()
            ->update('payment-1')
            ->reference('PAY-1002')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('/api.xro/2.0/Payments/payment-1', $request->path);
        self::assertSame(150.0, $payment->getAmount());
    }

    public function test_invoice_reference_hydrates_the_invoice_id(): void
    {
        $reference = (new InvoiceReference())->fill(['InvoiceID' => 'invoice-1']);

        self::assertSame('invoice-1', $reference->getInvoiceID());
        self::assertSame('invoice-2', $reference->setInvoiceID('invoice-2')->getInvoiceID());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->payments();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.payments.read', 'accounting.payments'], $scopes->granular);
    }

    public function test_it_can_paginate_payments(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['Payments' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->payments()
            ->paginate(page: 2, perPage: 40);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(40, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(40, $page->perPage);
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Payments' => [['PaymentID' => 'payment-1']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->payments()
            ->create()
            ->setPaymentID('payment-1')
            ->invoice('invoice-1')
            ->account('account-1')
            ->date('2026-03-25')
            ->amount(150)
            ->reference('PAY-3001')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('/api.xro/2.0/Payments/payment-1', $request->path);
        $json = $request->json ?? [];
        $pay = Json::extractFirst($json, 'Payments');
        self::assertNotNull($pay);
        self::assertSame('invoice-1', Json::extractObject($pay, 'Invoice')['InvoiceID']);
        self::assertSame('account-1', Json::extractObject($pay, 'Account')['AccountID']);
        self::assertSame('2026-03-25', $pay['Date']);
        self::assertSame(150.0, $pay['Amount']);
        self::assertSame('PAY-3001', $pay['Reference']);
    }

    public function test_it_hydrates_the_invoice_reference_and_account(): void
    {
        $payment = (new Payment())->fill([
            'PaymentID' => 'payment-1',
            'Invoice' => ['InvoiceID' => 'invoice-9'],
            'Account' => ['AccountID' => 'account-9'],
        ]);

        self::assertSame('invoice-9', $payment->getInvoiceID());
        self::assertSame('account-9', $payment->getAccountID());
    }

    public function test_it_serializes_writable_payment_fields_to_request(): void
    {
        $payment = (new Payment())
            ->setInvoiceID('invoice-1')
            ->setInvoiceNumber('INV-1001')
            ->setCreditNoteNumber('CN-1001')
            ->setCode('001')
            ->setCurrencyRate(0.75)
            ->setBankAmount(150)
            ->setIsReconciled(true)
            ->setStatus('AUTHORISED')
            ->setBankAccountNumber('123-456')
            ->setParticulars('particulars')
            ->setDetails('details')
            ->setCreditNote((new \Sujip\Xero\Accounting\CreditNote\CreditNote())->setCreditNoteID('creditnote-1'));

        $request = $payment->toRequest();

        self::assertSame('INV-1001', $request['InvoiceNumber']);
        self::assertSame('CN-1001', $request['CreditNoteNumber']);
        self::assertSame('001', $request['Code']);
        self::assertSame(0.75, $request['CurrencyRate']);
        self::assertSame(150, $request['BankAmount']);
        self::assertTrue($request['IsReconciled']);
        self::assertSame('AUTHORISED', $request['Status']);
        self::assertSame('123-456', $request['BankAccountNumber']);
        self::assertSame('particulars', $request['Particulars']);
        self::assertSame('details', $request['Details']);
        self::assertSame('creditnote-1', Json::extractObject(['CreditNote' => $request['CreditNote']], 'CreditNote')['CreditNoteID']);
        self::assertArrayNotHasKey('PaymentType', $request);
        self::assertArrayNotHasKey('UpdatedDateUTC', $request);
        self::assertArrayNotHasKey('UpdatedDateUTCString', $request);
        self::assertArrayNotHasKey('StatusAttributeString', $request);
        self::assertArrayNotHasKey('ValidationErrors', $request);
        self::assertArrayNotHasKey('Warnings', $request);
    }

    public function test_payment_setters_compose_remaining_fields(): void
    {
        $payment = (new Payment())
            ->setPrepayment((new \Sujip\Xero\Accounting\Prepayment\Prepayment())->setPrepaymentID('prepayment-1'))
            ->setOverpayment((new \Sujip\Xero\Accounting\Overpayment\Overpayment())->setOverpaymentID('overpayment-1'))
            ->setBatchPaymentID('batch-1')
            ->setPaymentType('ACCRECPAYMENT')
            ->setUpdatedDateUTC('2026-03-25T01:00:00')
            ->setUpdatedDateUTCString('2026-03-25T01:00:00Z')
            ->setHasAccount(true)
            ->setHasValidationErrors(false)
            ->setStatusAttributeString('OK');

        $payment->addValidationError((new \Sujip\Xero\Support\ValidationError())->setMessage('Some error'));
        $payment->addWarning((new \Sujip\Xero\Support\ValidationError())->setMessage('Some warning'));

        self::assertSame('prepayment-1', $payment->getPrepayment()?->getPrepaymentID());
        self::assertSame('overpayment-1', $payment->getOverpayment()?->getOverpaymentID());
        self::assertSame('batch-1', $payment->getBatchPaymentID());
        self::assertSame('ACCRECPAYMENT', $payment->getPaymentType());
        self::assertSame('2026-03-25T01:00:00', $payment->getUpdatedDateUTC());
        self::assertSame('2026-03-25T01:00:00Z', $payment->getUpdatedDateUTCString());
        self::assertTrue($payment->getHasAccount());
        self::assertFalse($payment->getHasValidationErrors());
        self::assertSame('OK', $payment->getStatusAttributeString());
        self::assertCount(1, $payment->getValidationErrors());
        self::assertSame('Some error', $payment->getValidationErrors()[0]->getMessage());
        self::assertCount(1, $payment->getWarnings());
        self::assertSame('Some warning', $payment->getWarnings()[0]->getMessage());
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $payment = (new Payment())
            ->amount(99)
            ->date('2026-04-01')
            ->setAccountID('account-9');

        self::assertSame(99.0, $payment->getAmount());
        self::assertSame('2026-04-01', $payment->getDate());
        self::assertSame('account-9', $payment->getAccountID());
    }

    public function test_loaded_payment_can_be_changed_and_saved(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Payments' => [['PaymentID' => 'payment-1', 'Amount' => 150]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Payments' => [['PaymentID' => 'payment-1', 'Amount' => 200]],
        ], JSON_THROW_ON_ERROR)));

        $payment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->payments()
            ->find('payment-1');

        $saved = $payment?->amount(200)->save();

        self::assertSame('/api.xro/2.0/Payments/payment-1', $transport->requests()[1]->path);
        self::assertSame(200.0, $saved?->getAmount());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Payment())->save();
    }

    public function test_history_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Payment())->history();
    }
}
