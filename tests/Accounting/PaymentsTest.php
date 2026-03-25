<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Payment\Payment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
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
        self::assertInstanceOf(Payment::class, $payments->first());
    }

    public function test_it_can_create_a_payment(): void
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
            ->invoice('invoice-1')
            ->account('account-1')
            ->date('2026-03-25')
            ->amount(150)
            ->reference('PAY-1001')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Payments', $request->path);
        self::assertSame('invoice-1', $request->json['Payments'][0]['Invoice']['InvoiceID']);
        self::assertSame(150.0, $payment->amount);
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
        self::assertSame(150.0, $payment->amount);
    }
}
