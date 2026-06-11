<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Auth;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Auth\ConnectionManager;
use Sujip\Xero\Auth\InMemoryTokenRepository;
use Sujip\Xero\Auth\OAuth2Client;
use Sujip\Xero\Auth\Token;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;

final class ConnectionManagerTest extends TestCase
{
    public function test_it_stores_exchanged_tokens(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'access_token' => 'access-token',
                'refresh_token' => 'refresh-token',
                'expires_in' => 1800,
                'scope' => 'offline_access accounting.contacts',
                'token_type' => 'Bearer',
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        $token = $manager->exchange('code-123', 'pkce-verifier');

        self::assertSame('access-token', $token->getAccessToken());
        $stored = $repository->get('default');
        self::assertNotNull($stored);
        self::assertSame('access-token', $stored->getAccessToken());
        self::assertNotNull($stored->getRefreshTokenExpiresAt());
        self::assertStringContainsString('code_verifier=pkce-verifier', (string) $transport->requests()[0]->body);
    }

    public function test_it_can_refresh_a_stored_token(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'access_token' => 'new-access-token',
                'refresh_token' => 'new-refresh-token',
                'expires_in' => 1800,
                'scope' => 'offline_access accounting.contacts',
                'token_type' => 'Bearer',
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('old-access-token', 'old-refresh-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        $token = $manager->refresh();

        self::assertSame('new-access-token', $token->getAccessToken());
        $stored = $repository->get('default');
        self::assertNotNull($stored);
        self::assertSame('new-refresh-token', $stored->getRefreshToken());
        self::assertNotNull($stored->getRefreshTokenExpiresAt());
    }

    public function test_it_can_connect_a_tenant_from_stored_token(): void
    {
        $transport = new FakeTransport();
        $transport->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'tenantId' => 'tenant-1',
                    'tenantName' => 'Acme Pty Ltd',
                ],
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('access-token', 'refresh-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        $connected = $manager->connectTenant('tenant-1');

        self::assertSame('tenant-1', $connected->getConnection()->getTenantId());
        self::assertSame('tenant-1', $connected->tenant()->context()->tenantId);
        self::assertSame('access-token', $connected->getToken()->getAccessToken());
        self::assertSame('tenant-1', $connected->getClient()->context()->tenantId);
    }

    public function test_it_builds_an_authorization_url(): void
    {
        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', new FakeTransport()),
            new InMemoryTokenRepository()
        );

        $url = $manager->authorizationUrl(['accounting.contacts'], 'state-123', 'challenge-abc');

        self::assertStringStartsWith('https://login.xero.com/identity/connect/authorize?', $url);
        self::assertStringContainsString('client_id=client-id', $url);
        self::assertStringContainsString('state=state-123', $url);
        self::assertStringContainsString('code_challenge=challenge-abc', $url);
    }

    public function test_it_lists_connections(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                ['id' => 'connection-1', 'tenantId' => 'tenant-1', 'tenantName' => 'Acme Pty Ltd'],
                ['id' => 'connection-2', 'tenantId' => 'tenant-2', 'tenantName' => 'Beta Pty Ltd'],
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('access-token', 'refresh-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        $connections = $manager->connections();

        self::assertCount(2, $connections);
        self::assertSame('tenant-1', $connections[0]->getTenantId());
    }

    public function test_it_can_disconnect_a_connection_by_id(): void
    {
        $transport = (new FakeTransport())->push(new Response(204));

        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('access-token', 'refresh-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        self::assertTrue($manager->disconnectConnection('connection-1'));
    }

    public function test_refresh_throws_without_a_refresh_token(): void
    {
        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('access-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', new FakeTransport()),
            $repository
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('does not have a refresh token');

        $manager->refresh();
    }

    public function test_connect_tenant_throws_for_an_unknown_tenant(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                ['id' => 'connection-1', 'tenantId' => 'tenant-1', 'tenantName' => 'Acme Pty Ltd'],
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('access-token', 'refresh-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No Xero connection found for tenant [tenant-9]');

        $manager->connectTenant('tenant-9');
    }

    public function test_disconnect_tenant_throws_for_an_unknown_tenant(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                ['id' => 'connection-1', 'tenantId' => 'tenant-1', 'tenantName' => 'Acme Pty Ltd'],
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('access-token', 'refresh-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No Xero connection found for tenant [tenant-9]');

        $manager->disconnectTenant('tenant-9');
    }

    public function test_it_can_exchange_and_connect_a_tenant_in_one_step(): void
    {
        $transport = new FakeTransport();
        $transport->push(
            new Response(200, body: json_encode([
                'access_token' => 'access-token',
                'refresh_token' => 'refresh-token',
                'expires_in' => 1800,
                'scope' => 'offline_access accounting.contacts',
                'token_type' => 'Bearer',
            ], JSON_THROW_ON_ERROR))
        );
        $transport->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'tenantId' => 'tenant-1',
                    'tenantName' => 'Acme Pty Ltd',
                ],
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        $connected = $manager->exchangeAndConnect('code-123', 'tenant-1', 'pkce-verifier');

        self::assertSame('tenant-1', $connected->getConnection()->getTenantId());
        self::assertSame('tenant-1', $connected->tenant()->context()->tenantId);
    }

    public function test_it_can_create_a_custom_connection_client(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'access_token' => 'custom-token',
                'expires_in' => 1800,
                'scope' => 'finance.statements.read',
                'token_type' => 'Bearer',
            ], JSON_THROW_ON_ERROR))
        );

        $repository = new InMemoryTokenRepository();
        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', null, $transport),
            $repository
        );

        $client = $manager->customConnection(['finance.statements.read']);

        self::assertSame('custom-token', $repository->get('default')?->getAccessToken());
        self::assertSame('custom-token', $client->context()->accessToken);
    }

    public function test_it_can_disconnect_a_tenant(): void
    {
        $transport = new FakeTransport();
        $transport->push(
            new Response(200, body: json_encode([
                [
                    'id' => 'connection-1',
                    'tenantId' => 'tenant-1',
                    'tenantName' => 'Acme Pty Ltd',
                ],
            ], JSON_THROW_ON_ERROR))
        );
        $transport->push(new Response(204));

        $repository = new InMemoryTokenRepository();
        $repository->put('default', new Token('access-token', 'refresh-token'));

        $manager = new ConnectionManager(
            new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport),
            $repository
        );

        self::assertTrue($manager->disconnectTenant('tenant-1'));
    }
}
