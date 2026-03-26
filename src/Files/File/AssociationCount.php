<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

final readonly class AssociationCount
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $objectId,
        public ?int $count,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['ObjectId']) ? (string) $payload['ObjectId'] : null,
            isset($payload['Count']) ? (int) $payload['Count'] : null,
            $payload
        );
    }
}
