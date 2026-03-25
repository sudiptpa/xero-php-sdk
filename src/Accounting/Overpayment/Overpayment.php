<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Overpayment;

final readonly class Overpayment
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
            $payload['OverpaymentID'] ?? null,
            $payload['Type'] ?? null,
            $payload['Status'] ?? null,
            $payload['RemainingCredit'] ?? null,
            $payload
        );
    }
}
