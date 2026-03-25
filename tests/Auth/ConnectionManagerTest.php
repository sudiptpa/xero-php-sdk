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

        $token = $manager->exchange('code-123');

        self::assertSame('access-token', $token->accessToken);
        self::assertSame('access-token', $repository->get('default')?->accessToken);
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

        self::assertSame('new-access-token', $token->accessToken);
        self::assertSame('new-refresh-token', $repository->get('default')?->refreshToken);
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

        self::assertSame('tenant-1', $connected->connection->tenantId);
        self::assertSame('tenant-1', $connected->client->context()->tenantId);
    }
}
