<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Account\Account;
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
}
