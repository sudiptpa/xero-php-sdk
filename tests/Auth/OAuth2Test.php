<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Auth;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Auth\OAuth2;

final class OAuth2Test extends TestCase
{
    public function test_it_builds_an_authorization_url(): void
    {
        $url = OAuth2::authorizationUrl(
            'client-id',
            'https://example.com/callback',
            ['openid', 'offline_access', 'accounting.contacts'],
            'state-123'
        );

        self::assertStringContainsString('client_id=client-id', $url);
        self::assertStringContainsString('redirect_uri=https%3A%2F%2Fexample.com%2Fcallback', $url);
        self::assertStringContainsString('scope=openid+offline_access+accounting.contacts', $url);
        self::assertStringContainsString('state=state-123', $url);
    }
}
