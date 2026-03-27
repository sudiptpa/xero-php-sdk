<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

use Sujip\Xero\Client;
use Sujip\Xero\Identity\Connection;
use Sujip\Xero\Xero;

final class ConnectionManager
{
    public function __construct(
        private readonly OAuth2Client $oauth2,
        private readonly TokenRepository $tokens,
        private readonly string $tokenKey = 'default'
    ) {
    }

    /**
     * @param list<string> $scopes
     */
    public function authorizationUrl(array $scopes, string $state, ?string $codeChallenge = null): string
    {
        return $this->oauth2->authorizationUrl($scopes, $state, $codeChallenge);
    }

    public function exchange(string $code, ?string $codeVerifier = null): Token
    {
        $token = $this->oauth2->exchangeAuthorizationCode($code, $codeVerifier);
        $this->tokens->put($this->tokenKey, $token);

        return $token;
    }

    public function refresh(): Token
    {
        $token = $this->storedToken();

        if (! $token->hasRefreshToken()) {
            throw new \RuntimeException('The stored token does not have a refresh token.');
        }

        $refreshed = $this->oauth2->refreshAccessToken((string) $token->refreshToken);
        $this->tokens->put($this->tokenKey, $refreshed);

        return $refreshed;
    }

    public function storedToken(): Token
    {
        return $this->tokens->get($this->tokenKey)
            ?? throw new \RuntimeException('No stored token found for the configured key.');
    }

    public function client(?Token $token = null): Client
    {
        return Xero::withToken($token ?? $this->storedToken(), $this->oauth2->transport());
    }

    /**
     * @return list<Connection>
     */
    public function connections(?Token $token = null): array
    {
        return $this->client($token)
            ->identity()
            ->connections()
            ->get()
            ->all();
    }

    public function connectTenant(string $tenantId, ?Token $token = null): ConnectedAccount
    {
        $client = $this->client($token);
        $connection = $client->identity()->connections()->findByTenant($tenantId)
            ?? throw new \RuntimeException('No Xero connection found for tenant [' . $tenantId . '].');

        return new ConnectedAccount(
            $token ?? $this->storedToken(),
            $connection,
            $client->tenant($tenantId)
        );
    }

    public function exchangeAndConnect(string $code, string $tenantId, ?string $codeVerifier = null): ConnectedAccount
    {
        return $this->connectTenant($tenantId, $this->exchange($code, $codeVerifier));
    }

    /**
     * @param list<string> $scopes
     */
    public function customConnection(array $scopes = []): Client
    {
        $token = $this->oauth2->customConnection($scopes);
        $this->tokens->put($this->tokenKey, $token);

        return $this->client($token);
    }
}
