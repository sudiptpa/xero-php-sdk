<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Journal;

final readonly class Journal
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?int $journalNumber,
        public ?string $sourceType,
        public ?string $sourceId,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['JournalID'] ?? null,
            isset($payload['JournalNumber']) ? (int) $payload['JournalNumber'] : null,
            $payload['SourceType'] ?? null,
            $payload['SourceID'] ?? null,
            $payload
        );
    }
}
