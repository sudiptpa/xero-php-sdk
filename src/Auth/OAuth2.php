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

        if (isset($payload['expires_in']) && is_numeric($payload['expires_in'])) {
            $expiresAt = (new DateTimeImmutable())->add(
                new DateInterval('PT' . (int) $payload['expires_in'] . 'S')
            );
        }

        $scopes = [];

        if (isset($payload['scope']) && is_string($payload['scope'])) {
            $scopes = array_values(array_filter(explode(' ', $payload['scope'])));
        }

        return new Token(
            (string) ($payload['access_token'] ?? ''),
            isset($payload['refresh_token']) ? (string) $payload['refresh_token'] : null,
            $expiresAt,
            $scopes,
            isset($payload['id_token']) ? (string) $payload['id_token'] : null,
            isset($payload['token_type']) ? (string) $payload['token_type'] : 'Bearer'
        );
    }
}
