<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;

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
            $payload['BatchPaymentID'] ?? null,
            $payload['Reference'] ?? null,
            $payload['Status'] ?? null,
            $payload['Amount'] ?? null,
            $payload,
            $client
        );
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access batch payment history without a bound client context and batch payment id.');
        }

        return (new BatchPayments($this->client))->history($this->id);
    }
}
