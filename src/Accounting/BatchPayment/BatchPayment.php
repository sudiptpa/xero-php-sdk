<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

final readonly class BatchPayment
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $reference,
        public ?string $status,
        public int|float|null $amount = null,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['BatchPaymentID'] ?? null,
            $payload['Reference'] ?? null,
            $payload['Status'] ?? null,
            $payload['Amount'] ?? null,
            $payload
        );
    }
}
