<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Http;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Request;
use Sujip\Xero\Http\Response;

final class FakeTransportTest extends TestCase
{
    public function test_it_returns_queued_responses_in_order(): void
    {
        $transport = (new FakeTransport())
            ->push(new Response(200, [], 'first'))
            ->push(new Response(201, [], 'second'));

        $first = $transport->send(new Request('GET', '/one'));
        $second = $transport->send(new Request('GET', '/two'));

        self::assertSame('first', $first->body);
        self::assertSame('second', $second->body);
        self::assertCount(2, $transport->requests());
        self::assertSame('/one', $transport->requests()[0]->path);
    }

    public function test_it_throws_when_no_response_is_queued(): void
    {
        $transport = new FakeTransport();

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No fake response queued.');

        $transport->send(new Request('GET', '/missing'));
    }
}
