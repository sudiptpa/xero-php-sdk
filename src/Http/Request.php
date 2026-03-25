<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

final readonly class Request
{
    /**
     * @param array<string, string> $headers
     * @param array<string, scalar|array<int, scalar>|null> $query
     * @param array<string, mixed>|null $json
     */
    public function __construct(
        public string $method,
        public string $path,
        public array $headers = [],
        public array $query = [],
        public ?array $json = null,
        public ?string $body = null,
        public bool $includeTenantHeader = true,
        public string $baseUri = ''
    ) {
    }

    public function withBaseUri(string $baseUri): self
    {
        return new self(
            $this->method,
            $this->path,
            $this->headers,
            $this->query,
            $this->json,
            $this->body,
            $this->includeTenantHeader,
            rtrim($baseUri, '/')
        );
    }

    /**
     * @param array<string, string> $headers
     */
    public function mergeHeaders(array $headers): self
    {
        return new self(
            $this->method,
            $this->path,
            array_merge($headers, $this->headers),
            $this->query,
            $this->json,
            $this->body,
            $this->includeTenantHeader,
            $this->baseUri
        );
    }

    public function withoutTenantHeader(): self
    {
        return new self(
            $this->method,
            $this->path,
            $this->headers,
            $this->query,
            $this->json,
            $this->body,
            false,
            $this->baseUri
        );
    }

    public function url(): string
    {
        $url = $this->baseUri === '' ? $this->path : $this->baseUri . $this->path;

        if ($this->query === []) {
            return $url;
        }

        return $url . '?' . http_build_query($this->query);
    }
}
