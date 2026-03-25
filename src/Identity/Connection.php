<?php

declare(strict_types=1);

namespace Sujip\Xero\Identity;

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
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['id'] ?? null,
            $payload['tenantId'] ?? null,
            $payload['tenantName'] ?? null,
            $payload['tenantType'] ?? null,
            $payload['createdDateUtc'] ?? null,
            $payload['updatedDateUtc'] ?? null,
            $payload
        );
    }
}
