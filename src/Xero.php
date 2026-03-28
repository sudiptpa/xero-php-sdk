<?php

declare(strict_types=1);

namespace Sujip\Xero;

use Sujip\Xero\Auth\OAuth2;
use Sujip\Xero\Auth\OAuth2Client;
use Sujip\Xero\Auth\Pkce;
use Sujip\Xero\Auth\Token;
use Sujip\Xero\Http\Transport;
use Sujip\Xero\Webhooks\WebhookVerifier;

final class Xero
{
    public static function withAccessToken(string $accessToken, ?Transport $transport = null): Client
    {
        return new Client(
            Context::make(accessToken: $accessToken),
            $transport
        );
    }

    public static function withToken(Token $token, ?Transport $transport = null): Client
    {
        return self::withAccessToken($token->getAccessToken(), $transport);
    }

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
        return OAuth2::authorizationUrl($clientId, $redirectUri, $scopes, $state, $codeChallenge, $codeChallengeMethod);
    }

    public static function oauth2(
        string $clientId,
        ?string $clientSecret = null,
        ?string $redirectUri = null
    ): OAuth2Client {
        return new OAuth2Client($clientId, $clientSecret, $redirectUri);
    }

    public static function webhookVerifier(string $signingKey): WebhookVerifier
    {
        return new WebhookVerifier($signingKey);
    }

    public static function pkce(): Pkce
    {
        return new Pkce();
    }
}
