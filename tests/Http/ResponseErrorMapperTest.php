<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Http;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Exceptions\AuthenticationException;
use Sujip\Xero\Exceptions\InsufficientScopeException;
use Sujip\Xero\Exceptions\RateLimitException;
use Sujip\Xero\Exceptions\RequestException;
use Sujip\Xero\Exceptions\ValidationException;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Http\ResponseErrorMapper;

final class ResponseErrorMapperTest extends TestCase
{
    public function test_it_maps_insufficient_scope_errors(): void
    {
        $exception = ResponseErrorMapper::map(
            new Response(401, ['WWW-Authenticate' => 'Bearer error="insufficient_scope"'])
        );

        self::assertInstanceOf(InsufficientScopeException::class, $exception);
    }

    public function test_it_maps_authentication_errors(): void
    {
        $exception = ResponseErrorMapper::map(new Response(403));

        self::assertInstanceOf(AuthenticationException::class, $exception);
    }

    public function test_it_maps_validation_errors(): void
    {
        $exception = ResponseErrorMapper::map(new Response(400));

        self::assertInstanceOf(ValidationException::class, $exception);
    }

    public function test_it_maps_rate_limit_errors(): void
    {
        $exception = ResponseErrorMapper::map(new Response(429));

        self::assertInstanceOf(RateLimitException::class, $exception);
    }

    public function test_it_maps_misspelled_insufficient_scope_errors(): void
    {
        $exception = ResponseErrorMapper::map(
            new Response(401, ['WWW-Authenticate' => 'Bearer error="insufficent_scope"'])
        );

        self::assertInstanceOf(InsufficientScopeException::class, $exception);
    }

    public function test_it_maps_plain_unauthorized_to_authentication_errors(): void
    {
        $exception = ResponseErrorMapper::map(new Response(401));

        self::assertInstanceOf(AuthenticationException::class, $exception);
    }

    public function test_it_maps_unprocessable_entity_to_validation_errors(): void
    {
        $exception = ResponseErrorMapper::map(new Response(422));

        self::assertInstanceOf(ValidationException::class, $exception);
    }

    public function test_it_falls_back_to_a_request_exception(): void
    {
        $exception = ResponseErrorMapper::map(new Response(500));

        self::assertSame(RequestException::class, $exception::class);
    }
}
