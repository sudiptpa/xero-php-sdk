<?php

declare(strict_types=1);

namespace Sujip\Xero\Identity;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Connection
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $tenantId,
        public ?string $tenantName,
        public ?string $tenantType,
        public ?string $createdDateUtc,
        public ?string $updatedDateUtc,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['id'] ?? null,
            $payload['tenantId'] ?? null,
            $payload['tenantName'] ?? null,
            $payload['tenantType'] ?? null,
            $payload['createdDateUtc'] ?? null,
            $payload['updatedDateUtc'] ?? null,
            $payload,
            $client
        );
    }

    public function disconnect(): bool
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot disconnect a connection without a bound client context and connection id.');
        }

        return (new Connections($this->client))->disconnect($this->id);
    }
}
