<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;

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
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['ReceiptID'] ?? null,
            $payload['ReceiptNumber'] ?? null,
            $payload['Status'] ?? null,
            $payload['Total'] ?? null,
            $payload,
            $client
        );
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access receipt attachments without a bound client context and receipt id.');
        }

        return (new Receipts($this->client))->attachments($this->id);
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access receipt history without a bound client context and receipt id.');
        }

        return (new Receipts($this->client))->history($this->id);
    }
}
