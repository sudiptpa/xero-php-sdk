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
