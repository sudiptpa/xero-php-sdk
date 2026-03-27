<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

final readonly class HistoryRecord
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $details,
        public ?string $dateUtc,
        public ?string $user,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['Details']) ? (string) $payload['Details'] : null,
            isset($payload['DateUTC']) ? (string) $payload['DateUTC'] : null,
            isset($payload['User']) ? (string) $payload['User'] : null,
            $payload
        );
    }
}
