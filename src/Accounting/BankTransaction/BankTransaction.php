<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransaction;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;

final readonly class BankTransaction
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $type,
        public ?string $status,
        public ?string $reference,
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
            $payload['BankTransactionID'] ?? null,
            $payload['Type'] ?? null,
            $payload['Status'] ?? null,
            $payload['Reference'] ?? null,
            $payload['Total'] ?? null,
            $payload,
            $client
        );
    }

    public function reference(string $reference): self
    {
        $payload = $this->raw;
        $payload['Reference'] = $reference;

        return new self($this->id, $this->type, $this->status, $reference, $this->total, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a bank transaction without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->type !== null) {
            $payload = $payload->type($this->type);
        }

        if ($this->reference !== null) {
            $payload = $payload->reference($this->reference);
        }

        return $payload->save();
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access bank transaction history without a bound client context and bank transaction id.');
        }

        return (new BankTransactions($this->client))->history($this->id);
    }
}
