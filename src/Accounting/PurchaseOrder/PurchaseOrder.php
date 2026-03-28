<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class PurchaseOrder implements SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $purchaseOrderID = null;

    private ?string $purchaseOrderNumber = null;

    private ?string $status = null;

    private ?string $reference = null;

    private ?Contact $contact = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    public function getPurchaseOrderID(): ?string
    {
        return $this->purchaseOrderID;
    }

    public function setPurchaseOrderID(?string $purchaseOrderID): self
    {
        $this->purchaseOrderID = $purchaseOrderID;

        return $this;
    }

    public function getPurchaseOrderNumber(): ?string
    {
        return $this->purchaseOrderNumber;
    }

    public function setPurchaseOrderNumber(?string $purchaseOrderNumber): self
    {
        $this->purchaseOrderNumber = $purchaseOrderNumber;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return list<LineItem>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    /**
     * @param list<LineItem> $lineItems
     */
    public function setLineItems(array $lineItems): self
    {
        $this->lineItems = $lineItems;

        return $this;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems[] = $lineItem;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'PurchaseOrderID' => $this->getPurchaseOrderID(),
            'PurchaseOrderNumber' => $this->getPurchaseOrderNumber(),
            'Status' => $this->getStatus(),
            'Reference' => $this->getReference(),
            'Contact' => $this->getContact()?->toRequest(),
            'LineItems' => array_map(
                static fn (LineItem $lineItem): array => $lineItem->toRequest(),
                $this->getLineItems()
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function reference(string $reference): self
    {
        return $this->setReference($reference);
    }

    public function contact(string $contactId): self
    {
        return $this->setContact(
            (new Contact())
                ->setContactID($contactId)
        );
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        return $this->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a purchase order without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->purchaseOrderID === null) {
            throw new RuntimeException('Cannot access purchase order attachments without a bound client context and purchase order id.');
        }

        return new Attachments($this->client, $this->purchaseOrderID);
    }

    public function history(): History
    {
        if ($this->client === null || $this->purchaseOrderID === null) {
            throw new RuntimeException('Cannot access purchase order history without a bound client context and purchase order id.');
        }

        return (new PurchaseOrders($this->client))->history($this->purchaseOrderID);
    }

    public function pdf(): string
    {
        if ($this->client === null || $this->purchaseOrderID === null) {
            throw new RuntimeException('Cannot access a purchase order PDF without a bound client context and purchase order id.');
        }

        return (new PurchaseOrders($this->client))->pdf($this->purchaseOrderID);
    }
}
