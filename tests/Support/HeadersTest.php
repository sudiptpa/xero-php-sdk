<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Support;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Support\Headers;

final class HeadersTest extends TestCase
{
    public function test_it_builds_no_headers_without_an_idempotency_key(): void
    {
        self::assertSame([], Headers::idempotency(null));
    }

    public function test_it_builds_an_idempotency_header(): void
    {
        self::assertSame(['Idempotency-Key' => 'key-1'], Headers::idempotency('key-1'));
    }
}
