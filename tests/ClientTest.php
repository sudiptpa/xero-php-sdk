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

        $client->accounting();
        $client->assets();
        $client->files();
        $client->projects();
        $client->payroll();
        $client->identity();
        $client->finance();
        $client->appStore();

        self::assertTrue(
            $client->webhooks()->verifier('signing-key')->verify('payload', base64_encode(hash_hmac('sha256', 'payload', 'signing-key', true)))
        );
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

    public function test_it_can_swap_token_on_an_existing_client(): void
    {
        $client = Xero::withAccessToken('old-token')
            ->tenant('tenant-123')
            ->withToken(new Token('new-token'));

        self::assertSame('new-token', $client->context()->accessToken);
        self::assertSame('tenant-123', $client->context()->tenantId);
    }

    public function test_context_tenant_headers_are_empty_without_a_tenant(): void
    {
        self::assertSame([], Context::make('token')->tenantHeaders());
        self::assertSame([], Context::make('token', '')->tenantHeaders());
    }

    public function test_xero_exposes_oauth_helpers(): void
    {
        $url = Xero::authorizationUrl(
            'client-id',
            'https://app.test/callback',
            ['accounting.contacts'],
            'state-123'
        );
        $oauthUrl = Xero::oauth2('client-id', 'client-secret', 'https://app.test/callback')
            ->authorizationUrl(['accounting.contacts'], 'state-123');
        $pkce = Xero::pkce();
        $verifier = $pkce::verifier();

        self::assertStringContainsString('client_id=client-id', $url);
        self::assertStringContainsString('state=state-123', $url);
        self::assertStringContainsString('client_id=client-id', $oauthUrl);
        self::assertSame(64, strlen($verifier));
        self::assertSame(43, strlen($pkce::challenge($verifier)));
    }
}
