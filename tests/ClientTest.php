<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Auth\Token;
use Sujip\Xero\Context;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Xero;

final class ClientTest extends TestCase
{
    public function test_it_creates_a_tenant_aware_client(): void
    {
        $client = Xero::withAccessToken('token')
            ->tenant('tenant-123');

        self::assertSame('tenant-123', $client->context()->tenantId);
    }

    public function test_it_can_swap_transport(): void
    {
        $transport = new FakeTransport();
        $client = Xero::withAccessToken('token')->withTransport($transport);

        self::assertSame('', $client->context()->tenantId ?? '');
    }

    public function test_context_exposes_auth_headers(): void
    {
        $headers = Context::make('token', 'tenant-123')->authHeaders();

        self::assertSame('Bearer token', $headers['Authorization']);
        self::assertSame('application/json', $headers['Accept']);
        self::assertSame('tenant-123', Context::make('token', 'tenant-123')->tenantHeaders()['Xero-Tenant-Id']);
    }

    public function test_it_exposes_domain_roots(): void
    {
        $client = Xero::withAccessToken('token');

        $this->expectNotToPerformAssertions();
        $client->accounting();
        $client->assets();
        $client->files();
        $client->projects();
        $client->payroll();
        $client->identity();
        $client->finance();
        $client->appStore();
    }

    public function test_it_can_swap_to_native_transport(): void
    {
        $client = Xero::withAccessToken('token')->usingNativeTransport();

        self::assertSame('https://api.xero.com', $client->context()->baseUri);
    }

    public function test_it_can_create_a_client_from_token_object(): void
    {
        $client = Xero::withToken(new Token('token-value'))->tenant('tenant-123');

        self::assertSame('token-value', $client->context()->accessToken);
        self::assertSame('tenant-123', $client->context()->tenantId);
    }
}
