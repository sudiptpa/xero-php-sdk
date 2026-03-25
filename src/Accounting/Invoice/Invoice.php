<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class Invoice
{
    /**
     * @param list<array<string, mixed>> $lineItems
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $status,
        public ?string $reference,
        public ?string $type,
        public array $lineItems = [],
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
            $payload['InvoiceID'] ?? null,
            $payload['Status'] ?? null,
            $payload['Reference'] ?? null,
            $payload['Type'] ?? null,
            $payload['LineItems'] ?? [],
            $payload,
            $client
        );
    }

    public function reference(string $reference): self
    {
        $payload = $this->raw;
        $payload['Reference'] = $reference;

        return new self($this->id, $this->status, $reference, $this->type, $this->lineItems, $payload, $this->client);
    }

    public function type(string $type): self
    {
        $type = strtoupper($type);
        $payload = $this->raw;
        $payload['Type'] = $type;

        return new self($this->id, $this->status, $this->reference, $type, $this->lineItems, $payload, $this->client);
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $lineItems = $this->lineItems;
        $lineItems[] = [
            'Description' => $description,
            'Quantity' => $quantity,
            'UnitAmount' => $unitAmount,
        ];

        $payload = $this->raw;
        $payload['LineItems'] = $lineItems;

        return new self($this->id, $this->status, $this->reference, $this->type, $lineItems, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an invoice without a bound client context.');
        }

        $draft = new Draft($this->client);

        if ($this->id !== null) {
            $draft = $draft->id($this->id);
        }

        if ($this->type !== null) {
            $draft = $draft->type($this->type);
        }

        if ($this->reference !== null) {
            $draft = $draft->reference($this->reference);
        }

        foreach ($this->lineItems as $lineItem) {
            $draft = $draft->lineItem(
                (string) ($lineItem['Description'] ?? ''),
                (float) ($lineItem['Quantity'] ?? 0),
                (float) ($lineItem['UnitAmount'] ?? 0)
            );
        }

        return $draft->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access invoice attachments without a bound client context and invoice id.');
        }

        return new Attachments($this->client, $this->id);
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access invoice history without a bound client context and invoice id.');
        }

        return new History($this->client, $this->id);
    }

    public function pdf(): string
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access invoice PDF without a bound client context and invoice id.');
        }

        return (new Invoices($this->client))->pdf($this->id);
    }
}
