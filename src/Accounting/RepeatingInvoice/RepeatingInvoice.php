<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class RepeatingInvoice
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $type,
        public ?string $status,
        public ?string $reference,
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
            $payload['RepeatingInvoiceID'] ?? null,
            $payload['Type'] ?? null,
            $payload['Status'] ?? null,
            $payload['Reference'] ?? null,
            $payload,
            $client
        );
    }

    public function reference(string $reference): self
    {
        $payload = $this->raw;
        $payload['Reference'] = $reference;

        return new self($this->id, $this->type, $this->status, $reference, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a repeating invoice without a bound client context.');
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
}
