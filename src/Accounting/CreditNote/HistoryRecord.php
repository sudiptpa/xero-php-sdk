<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

final readonly class HistoryRecord
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $details,
        public ?string $user,
        public ?string $changes,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['Details'] ?? null,
            $payload['User'] ?? null,
            $payload['Changes'] ?? null,
            $payload
        );
    }
}
