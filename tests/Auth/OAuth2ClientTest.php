<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Auth;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Auth\OAuth2Client;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;

final class OAuth2ClientTest extends TestCase
{
    public function test_it_exchanges_an_authorization_code(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'access_token' => 'access-token',
                'refresh_token' => 'refresh-token',
                'expires_in' => 1800,
                'scope' => 'openid offline_access accounting.contacts',
                'token_type' => 'Bearer',
            ], JSON_THROW_ON_ERROR))
        );

        $token = (new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport))
            ->exchangeAuthorizationCode('code-123', 'verifier-123');

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('https://identity.xero.com/connect/token', $request->path);
        self::assertStringContainsString('grant_type=authorization_code', (string) $request->body);
        self::assertStringContainsString('code_verifier=verifier-123', (string) $request->body);
        self::assertSame('access-token', $token->getAccessToken());
        self::assertSame('refresh-token', $token->getRefreshToken());
        self::assertNotNull($token->getRefreshTokenExpiresAt());
    }

    public function test_it_refreshes_an_access_token(): void
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

        $token = (new OAuth2Client('client-id', 'client-secret', 'https://example.com/callback', $transport))
            ->refreshAccessToken('refresh-token');

        $request = $transport->requests()[0];

        self::assertStringContainsString('grant_type=refresh_token', (string) $request->body);
        self::assertStringContainsString('refresh_token=refresh-token', (string) $request->body);
        self::assertSame('new-access-token', $token->getAccessToken());
        self::assertNotNull($token->getRefreshTokenExpiresAt());
    }

    public function test_it_can_request_a_custom_connection_token(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'access_token' => 'custom-connection-token',
                'expires_in' => 1800,
                'scope' => 'finance.statements.read',
                'token_type' => 'Bearer',
            ], JSON_THROW_ON_ERROR))
        );

        $token = (new OAuth2Client('client-id', 'client-secret', null, $transport))
            ->customConnection(['finance.statements.read']);

        $request = $transport->requests()[0];

        self::assertStringContainsString('grant_type=client_credentials', (string) $request->body);
        self::assertStringContainsString('scope=finance.statements.read', (string) $request->body);
        self::assertSame('custom-connection-token', $token->getAccessToken());
    }

}
