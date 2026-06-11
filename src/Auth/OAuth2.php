<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

use DateInterval;
use DateTimeImmutable;

final class OAuth2
{
    private const AUTHORIZE_URL = 'https://login.xero.com/identity/connect/authorize';
    private const TOKEN_URL = 'https://identity.xero.com/connect/token';

    /**
     * @param list<string> $scopes
     */
    public static function authorizationUrl(
        string $clientId,
        string $redirectUri,
        array $scopes,
        string $state,
        ?string $codeChallenge = null,
        string $codeChallengeMethod = 'S256'
    ): string {
        $query = [
            'response_type' => 'code',
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'scope' => implode(' ', $scopes),
            'state' => $state,
        ];

        if ($codeChallenge !== null && $codeChallenge !== '') {
            $query['code_challenge'] = $codeChallenge;
            $query['code_challenge_method'] = $codeChallengeMethod;
        }

        return self::AUTHORIZE_URL . '?' . http_build_query($query);
    }

    public static function tokenUrl(): string
    {
        return self::TOKEN_URL;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function tokenFromArray(array $payload): Token
    {
        $expiresAt = null;
        $refreshTokenExpiresAt = null;
        $now = new DateTimeImmutable();

        if (isset($payload['expires_in']) && is_numeric($payload['expires_in'])) {
            $expiresAt = $now->add(
                new DateInterval('PT' . (int) $payload['expires_in'] . 'S')
            );
        }

        if (isset($payload['refresh_token']) && is_string($payload['refresh_token']) && $payload['refresh_token'] !== '') {
            // Xero refresh tokens expire after 60 days of non-use.
            $refreshTokenExpiresAt = $now->add(new DateInterval('P60D'));
        }

        $scopes = [];

        if (isset($payload['scope']) && is_string($payload['scope'])) {
            $scopes = array_values(array_filter(explode(' ', $payload['scope'])));
        }

        return new Token(
            is_string($payload['access_token'] ?? null) ? $payload['access_token'] : '',
            is_string($payload['refresh_token'] ?? null) ? $payload['refresh_token'] : null,
            $expiresAt,
            $refreshTokenExpiresAt,
            $scopes,
            is_string($payload['id_token'] ?? null) ? $payload['id_token'] : null,
            is_string($payload['token_type'] ?? null) ? $payload['token_type'] : 'Bearer'
        );
    }
}
