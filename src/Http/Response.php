<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

use RuntimeException;
use Sujip\Xero\Support\Json;

final readonly class Response
{
    /**
     * @param array<string, string> $headers
     */
    public function __construct(
        public int $status,
        public array $headers = [],
        public string $body = ''
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function json(): array
    {
        if ($this->body === '') {
            return [];
        }

        $decoded = Json::decode($this->body);

        if (! is_array($decoded)) {
            throw new RuntimeException('Unable to decode JSON response body.');
        }

        return $decoded;
    }

    public function header(string $name, ?string $default = null): ?string
    {
        return $this->headers[$name] ?? $default;
    }
}
