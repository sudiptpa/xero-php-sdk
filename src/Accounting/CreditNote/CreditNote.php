<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class CreditNote implements SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $creditNoteID = null;

    private ?string $type = null;

    private ?string $status = null;

    private ?string $reference = null;

    private int|float|null $total = null;

    private ?Contact $contact = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    public function getCreditNoteID(): ?string
    {
        return $this->creditNoteID;
    }

    public function setCreditNoteID(?string $creditNoteID): self
    {
        $this->creditNoteID = $creditNoteID;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type === null ? null : strtoupper($type);

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

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

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
            'CreditNoteID' => $this->getCreditNoteID(),
            'Type' => $this->getType(),
            'Status' => $this->getStatus(),
            'Reference' => $this->getReference(),
            'Total' => $this->getTotal(),
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

    public function type(string $type): self
    {
        return $this->setType($type);
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
            throw new RuntimeException('Cannot save a credit note without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->creditNoteID === null) {
            throw new RuntimeException('Cannot access credit note attachments without a bound client context and credit note id.');
        }

        return new Attachments($this->client, $this->creditNoteID);
    }

    public function history(): History
    {
        if ($this->client === null || $this->creditNoteID === null) {
            throw new RuntimeException('Cannot access credit note history without a bound client context and credit note id.');
        }

        return new History($this->client, $this->creditNoteID);
    }

    public function pdf(): string
    {
        if ($this->client === null || $this->creditNoteID === null) {
            throw new RuntimeException('Cannot access credit note PDF without a bound client context and credit note id.');
        }

        return (new CreditNotes($this->client))->pdf($this->creditNoteID);
    }
}
