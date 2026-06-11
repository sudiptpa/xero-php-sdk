<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Http;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\Response;

final class ResponseTest extends TestCase
{
    public function test_it_decodes_a_json_body(): void
    {
        self::assertSame(['Status' => 'OK'], (new Response(200, [], '{"Status":"OK"}'))->json());
    }

    public function test_it_returns_an_empty_array_for_an_empty_body(): void
    {
        self::assertSame([], (new Response(204))->json());
    }

    public function test_it_reads_headers_with_a_default(): void
    {
        $response = new Response(200, ['Content-Type' => 'application/json']);

        self::assertSame('application/json', $response->header('Content-Type'));
        self::assertNull($response->header('X-Missing'));
        self::assertSame('fallback', $response->header('X-Missing', 'fallback'));
    }
}
