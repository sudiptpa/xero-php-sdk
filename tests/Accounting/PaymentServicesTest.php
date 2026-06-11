<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\PaymentService\PaymentService;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class PaymentServicesTest extends TestCase
{
    public function test_it_can_list_payment_services(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'PaymentServices' => [[
                    'PaymentServiceName' => 'Stripe',
                    'PaymentServiceUrl' => 'https://example.test/pay',
                    'PayNowText' => 'Pay online',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $services = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->paymentServices()
            ->get();

        self::assertSame('/api.xro/2.0/PaymentServices', $transport->requests()[0]->path);
        self::assertInstanceOf(PaymentService::class, $services->first());
    }

    public function test_it_can_create_payment_services(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'PaymentServices' => [[
                    'PaymentServiceName' => 'Stripe',
                    'PaymentServiceUrl' => 'https://example.test/pay',
                    'PayNowText' => 'Pay online',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $service = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->paymentServices()
            ->create()
            ->name('Stripe')
            ->url('https://example.test/pay')
            ->payNowText('Pay online')
            ->idempotencyKey('service-key')
            ->save();

        self::assertSame('PUT', $transport->requests()[0]->method);
        self::assertSame('/api.xro/2.0/PaymentServices', $transport->requests()[0]->path);
        self::assertSame('service-key', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame('Stripe', $service->getPaymentServiceName());
        self::assertSame('https://example.test/pay', $service->getPaymentServiceUrl());
        self::assertSame('Pay online', $service->getPayNowText());
    }

    public function test_it_exposes_required_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->paymentServices()
            ->scopes();

        self::assertSame(['paymentservices'], $scopes->broad);
        self::assertSame([], $scopes->granular);
    }
}
