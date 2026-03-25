<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Prepayment;

final readonly class Prepayment
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $type,
        public ?string $status,
        public int|float|null $remainingCredit = null,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['PrepaymentID'] ?? null,
            $payload['Type'] ?? null,
            $payload['Status'] ?? null,
            $payload['RemainingCredit'] ?? null,
            $payload
        );
    }
}
