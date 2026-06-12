<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\BrandingTheme\BrandingTheme;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class BrandingThemesTest extends TestCase
{
    public function test_it_can_list_and_find_branding_themes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'BrandingThemes' => [[
                'BrandingThemeID' => 'branding-1',
                'Name' => 'Standard',
                'SortOrder' => 1,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'BrandingThemes' => [[
                'BrandingThemeID' => 'branding-1',
                'Name' => 'Standard',
                'SortOrder' => 1,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $themes = $client->accounting()->brandingThemes()->get();
        $theme = $client->accounting()->brandingThemes()->find('branding-1');

        self::assertSame('/api.xro/2.0/BrandingThemes', $transport->requests()[0]->path);
        self::assertInstanceOf(BrandingTheme::class, $themes->first());
        self::assertSame('Standard', $themes->first()->getName());
        self::assertSame('1', $themes->first()->getSortOrder());
        self::assertSame('/api.xro/2.0/BrandingThemes/branding-1', $transport->requests()[1]->path);
        self::assertSame('branding-1', $theme?->getBrandingThemeID());
    }

    public function test_it_lists_branding_theme_payment_services(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'PaymentServices' => [[
                'PaymentServiceID' => 'service-1',
                'PaymentServiceName' => 'ACME Payment',
                'PaymentServiceUrl' => 'https://www.payupnow.com/',
                'PaymentServiceType' => 'Custom',
                'PayNowText' => 'Pay Now',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $services = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->brandingThemes()
            ->paymentServices('branding-1');

        self::assertSame('/api.xro/2.0/BrandingThemes/branding-1/PaymentServices', $transport->requests()[0]->path);
        $service = $services->first();
        self::assertNotNull($service);
        self::assertSame('service-1', $service->getPaymentServiceID());
        self::assertSame('Custom', $service->getPaymentServiceType());
        self::assertSame('ACME Payment', $service->getPaymentServiceName());
    }

    public function test_it_applies_a_payment_service_to_a_branding_theme(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'PaymentServices' => [['PaymentServiceID' => 'service-1', 'PaymentServiceName' => 'ACME Payment']],
        ], JSON_THROW_ON_ERROR)));

        $services = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->brandingThemes()
            ->applyPaymentService('branding-1', 'service-1', 'service-key');

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/BrandingThemes/branding-1/PaymentServices', $request->path);
        self::assertSame(['PaymentServices' => [['PaymentServiceID' => 'service-1']]], $request->json);
        self::assertSame('service-key', $request->headers['Idempotency-Key']);
        self::assertSame('service-1', $services->first()?->getPaymentServiceID());
    }

    public function test_it_exposes_required_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->brandingThemes()
            ->scopes();

        self::assertNotSame([], $scopes->broad);
        self::assertNotSame([], $scopes->granular);
    }
}
