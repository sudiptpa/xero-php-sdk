<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

final readonly class Receipt
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $receiptNumber,
        public ?string $status,
        public int|float|null $total = null,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['ReceiptID'] ?? null,
            $payload['ReceiptNumber'] ?? null,
            $payload['Status'] ?? null,
            $payload['Total'] ?? null,
            $payload
        );
    }
}
