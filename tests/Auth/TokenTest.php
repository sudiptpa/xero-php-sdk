<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Auth;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Auth\Token;

final class TokenTest extends TestCase
{
    public function test_it_exposes_all_token_attributes(): void
    {
        $expiresAt = new DateTimeImmutable('2026-06-06 12:00:00');
        $refreshExpiresAt = new DateTimeImmutable('2026-12-06 12:00:00');

        $token = new Token(
            accessToken: 'access',
            refreshToken: 'refresh',
            expiresAt: $expiresAt,
            refreshTokenExpiresAt: $refreshExpiresAt,
            scopes: ['offline_access', 'accounting.contacts'],
            idToken: 'id-token',
            tokenType: 'Bearer'
        );

        self::assertSame('access', $token->getAccessToken());
        self::assertSame('refresh', $token->getRefreshToken());
        self::assertSame($expiresAt, $token->getExpiresAt());
        self::assertSame($refreshExpiresAt, $token->getRefreshTokenExpiresAt());
        self::assertSame(['offline_access', 'accounting.contacts'], $token->getScopes());
        self::assertSame('id-token', $token->getIdToken());
        self::assertSame('Bearer', $token->getTokenType());
        self::assertTrue($token->hasRefreshToken());
    }

    public function test_it_reports_no_refresh_token(): void
    {
        self::assertFalse((new Token('access'))->hasRefreshToken());
        self::assertFalse((new Token('access', ''))->hasRefreshToken());
    }

    public function test_expiry_defaults_to_not_expired_without_a_date(): void
    {
        $token = new Token('access');

        self::assertFalse($token->isExpired());
        self::assertFalse($token->isRefreshTokenExpired());
    }

    public function test_it_detects_an_expired_access_token(): void
    {
        $now = new DateTimeImmutable('2026-06-06 12:00:00');

        $expired = new Token('access', expiresAt: new DateTimeImmutable('2026-06-06 11:59:59'));
        $valid = new Token('access', expiresAt: new DateTimeImmutable('2026-06-06 12:00:01'));

        self::assertTrue($expired->isExpired($now));
        self::assertFalse($valid->isExpired($now));
    }

    public function test_it_detects_an_expired_refresh_token(): void
    {
        $now = new DateTimeImmutable('2026-06-06 12:00:00');

        $expired = new Token('access', refreshTokenExpiresAt: new DateTimeImmutable('2026-06-06 11:00:00'));
        $valid = new Token('access', refreshTokenExpiresAt: new DateTimeImmutable('2026-06-06 13:00:00'));

        self::assertTrue($expired->isRefreshTokenExpired($now));
        self::assertFalse($valid->isRefreshTokenExpired($now));
    }
}
