<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

use DateTimeInterface;
use Sujip\Xero\Client;

final class PendingRequest
{
    /**
     * @var array<string, scalar|array<int, scalar>|null>
     */
    private array $query = [];

    /**
     * @var array<string, mixed>|null
     */
    private ?array $json = null;

    private ?string $body = null;

    /**
     * @var array<string, string>
     */
    private array $headers = [];

    private bool $includeTenantHeader = true;

    public function __construct(
        private readonly Client $client,
        private readonly string $method,
        private readonly string $path
    ) {
    }

    /**
     * @param array<string, scalar|array<int, scalar>|null> $query
     */
    public function withQuery(array $query): self
    {
        $clone = clone $this;
        $clone->query = array_merge($this->query, $query);

        return $clone;
    }

    /**
     * @param array<string, mixed> $json
     */
    public function withJson(array $json): self
    {
        $clone = clone $this;
        $clone->json = $json;

        return $clone;
    }

    public function withBody(string $body): self
    {
        $clone = clone $this;
        $clone->body = $body;

        return $clone;
    }

    /**
     * @param array<string, string> $headers
     */
    public function withHeaders(array $headers): self
    {
        $clone = clone $this;
        $clone->headers = array_merge($this->headers, $headers);

        return $clone;
    }

    public function acceptJson(): self
    {
        return $this->withHeaders(['Accept' => 'application/json']);
    }

    public function contentTypeJson(): self
    {
        return $this->withHeaders(['Content-Type' => 'application/json']);
    }

    public function modifiedSince(DateTimeInterface $date): self
    {
        return $this->withHeaders([
            'If-Modified-Since' => $date->format(DateTimeInterface::RFC7231),
        ]);
    }

    public function withoutTenant(): self
    {
        $clone = clone $this;
        $clone->includeTenantHeader = false;

        return $clone;
    }

    public function send(): Response
    {
        return $this->client->send(
            new Request(
                $this->method,
                $this->path,
                headers: $this->headers,
                query: $this->query,
                json: $this->json,
                body: $this->body,
                includeTenantHeader: $this->includeTenantHeader
            )
        );
    }
}
