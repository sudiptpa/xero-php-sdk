<?php

declare(strict_types=1);

namespace Sujip\Xero\Auth;

use Sujip\Xero\Http\NativeTransport;
use Sujip\Xero\Http\Request;
use Sujip\Xero\Http\Transport;

final class OAuth2Client
{
    private Transport $transport;

    public function __construct(
        private readonly string $clientId,
        private readonly ?string $clientSecret = null,
        private readonly ?string $redirectUri = null,
        ?Transport $transport = null
    ) {
        $this->transport = $transport ?? new NativeTransport();
    }

    /**
     * @param list<string> $scopes
     */
    public function authorizationUrl(
        array $scopes,
        string $state,
        ?string $codeChallenge = null,
        string $codeChallengeMethod = 'S256'
    ): string {
        return OAuth2::authorizationUrl(
            $this->clientId,
            $this->redirectUri ?? '',
            $scopes,
            $state,
            $codeChallenge,
            $codeChallengeMethod
        );
    }

    public function exchangeAuthorizationCode(string $code, ?string $codeVerifier = null): Token
    {
        $payload = [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->redirectUri ?? '',
        ];

        if ($codeVerifier !== null && $codeVerifier !== '') {
            $payload['code_verifier'] = $codeVerifier;
        }

        return $this->sendTokenRequest($payload);
    }

    public function refreshAccessToken(string $refreshToken): Token
    {
        return $this->sendTokenRequest([
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);
    }

    /**
     * @param list<string> $scopes
     */
    public function clientCredentials(array $scopes = []): Token
    {
        $payload = [
            'grant_type' => 'client_credentials',
        ];

        if ($scopes !== []) {
            $payload['scope'] = implode(' ', $scopes);
        }

        return $this->sendTokenRequest($payload);
    }

    /**
     * Xero custom connections use the client credentials flow and do not involve tenant discovery.
     *
     * @param list<string> $scopes
     */
    public function customConnection(array $scopes = []): Token
    {
        return $this->clientCredentials($scopes);
    }

    public function manager(TokenRepository $tokens, string $tokenKey = 'default'): ConnectionManager
    {
        return new ConnectionManager($this, $tokens, $tokenKey);
    }

    public function transport(): Transport
    {
        return $this->transport;
    }

    /**
     * @param array<string, string> $payload
     */
    private function sendTokenRequest(array $payload): Token
    {
        $response = $this->transport->send(
            new Request(
                'POST',
                OAuth2::tokenUrl(),
                headers: [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . ($this->clientSecret ?? '')),
                ],
                body: http_build_query($payload)
            )
        );

        return OAuth2::tokenFromArray($response->json());
    }
}
