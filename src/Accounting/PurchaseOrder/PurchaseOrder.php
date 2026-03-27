<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;

final readonly class PurchaseOrder
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $purchaseOrderNumber,
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
            $payload['PurchaseOrderID'] ?? null,
            $payload['PurchaseOrderNumber'] ?? null,
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

        return new self($this->id, $this->purchaseOrderNumber, $this->status, $reference, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a purchase order without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->reference !== null) {
            $payload = $payload->reference($this->reference);
        }

        return $payload->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access purchase order attachments without a bound client context and purchase order id.');
        }

        return new Attachments($this->client, $this->id);
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access purchase order history without a bound client context and purchase order id.');
        }

        return (new PurchaseOrders($this->client))->history($this->id);
    }
}
