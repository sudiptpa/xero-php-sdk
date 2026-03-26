<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final readonly class LockHistory
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $lockDate,
        public ?string $lockType,
        public ?string $changedDateUtc,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['LockDate']) ? (string) $payload['LockDate'] : null,
            isset($payload['LockType']) ? (string) $payload['LockType'] : null,
            isset($payload['ChangedDateUTC']) ? (string) $payload['ChangedDateUTC'] : null,
            $payload
        );
    }
}
