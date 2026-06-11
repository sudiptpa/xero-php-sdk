<?php

declare(strict_types=1);

namespace Sujip\Xero\Http;

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

        return Json::decodeObject($this->body);
    }

    public function header(string $name, ?string $default = null): ?string
    {
        return $this->headers[$name] ?? $default;
    }
}
