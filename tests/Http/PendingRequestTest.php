<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Http;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class PendingRequestTest extends TestCase
{
    private function transport(): FakeTransport
    {
        return (new FakeTransport())->push(new Response(200, [], '{}'));
    }

    public function test_it_applies_json_and_conditional_headers(): void
    {
        $transport = $this->transport();

        Xero::withAccessToken('token')
            ->tenant('tenant-1')
            ->withTransport($transport)
            ->get('/Invoices')
            ->acceptJson()
            ->contentTypeJson()
            ->modifiedSince(new DateTimeImmutable('2026-03-25 10:00:00', new \DateTimeZone('UTC')))
            ->send();

        $request = $transport->requests()[0];

        self::assertSame('application/json', $request->headers['Accept']);
        self::assertSame('application/json', $request->headers['Content-Type']);
        self::assertSame('Wed, 25 Mar 2026 10:00:00 GMT', $request->headers['If-Modified-Since']);
    }

    public function test_it_can_omit_the_tenant_header(): void
    {
        $transport = $this->transport();

        Xero::withAccessToken('token')
            ->tenant('tenant-1')
            ->withTransport($transport)
            ->get('/connections')
            ->withoutTenant()
            ->send();

        $request = $transport->requests()[0];

        self::assertFalse($request->includeTenantHeader);
        self::assertArrayNotHasKey('Xero-Tenant-Id', $request->headers);
    }
}
