<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\LinkedTransaction;

final readonly class LinkedTransaction
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $sourceTransactionId,
        public ?string $targetTransactionId,
        public ?string $contactId,
        public ?string $status,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['LinkedTransactionID'] ?? null,
            $payload['SourceTransactionID'] ?? null,
            $payload['TargetTransactionID'] ?? null,
            $payload['ContactID'] ?? null,
            $payload['Status'] ?? null,
            $payload
        );
    }
}
