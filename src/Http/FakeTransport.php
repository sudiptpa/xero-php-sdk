<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

use RuntimeException;

final class FakeTransport implements Transport
{
    /**
     * @var list<Response>
     */
    private array $responses = [];

    /**
     * @var list<Request>
     */
    private array $requests = [];

    public function push(Response $response): self
    {
        $this->responses[] = $response;

        return $this;
    }

    public function send(Request $request): Response
    {
        $this->requests[] = $request;

        if ($this->responses === []) {
            throw new RuntimeException('No fake response queued.');
        }

        return array_shift($this->responses);
    }

    /**
     * @return list<Request>
     */
    public function requests(): array
    {
        return $this->requests;
    }
}
