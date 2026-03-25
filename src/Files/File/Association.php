<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

final readonly class Association
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $objectId,
        public ?string $objectType,
        public ?string $objectGroup,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['ObjectId'] ?? null,
            $payload['ObjectType'] ?? null,
            $payload['ObjectGroup'] ?? null,
            $payload
        );
    }
}
