<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Invoice extends Model implements SerializesRequest
{
    private ?string $invoiceID = null;

    private ?string $status = null;

    private ?string $reference = null;

    private ?string $type = null;

    private ?Contact $contact = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getInvoiceID(): ?string
    {
        return $this->invoiceID;
    }

    public function setInvoiceID(?string $invoiceID): self
    {
        $this->invoiceID = $invoiceID;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type === null ? null : strtoupper($type);

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

    public function getContactID(): ?string
    {
        return $this->contact?->getContactID();
    }

    public function setContactID(?string $contactID): self
    {
        $contact = $this->contact ?? new Contact();
        $contact->setContactID($contactID);
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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'InvoiceID' => Field::string(),
            'Status' => Field::string(),
            'Reference' => Field::string(),
            'Type' => Field::string(),
            'Contact' => Field::object(Contact::class),
            'LineItems' => Field::many(LineItem::class),
        ];
    }

    protected function newDefinitionInstance(string $class): object
    {
        if ($class === Contact::class) {
            return new Contact($this->client);
        }

        return parent::newDefinitionInstance($class);
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        $contact = $this->getContact();

        return array_filter([
            'InvoiceID' => $this->getInvoiceID(),
            'Type' => $this->getType(),
            'Status' => $this->getStatus(),
            'Reference' => $this->getReference(),
            'Contact' => $contact?->toRequest(),
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

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        return $this->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );
    }

    public function draft(): self
    {
        return $this->setStatus('DRAFT');
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an invoice without a bound client context.');
        }

        $draft = new Draft($this->client);

        return $draft->using($this)->save();
    }

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->invoiceID === null) {
            throw new RuntimeException('Cannot access invoice attachments without a bound client context and invoice id.');
        }

        return new Attachments($this->client, $this->invoiceID);
    }

    public function history(): History
    {
        if ($this->client === null || $this->invoiceID === null) {
            throw new RuntimeException('Cannot access invoice history without a bound client context and invoice id.');
        }

        return new History($this->client, $this->invoiceID);
    }

    public function pdf(): string
    {
        if ($this->client === null || $this->invoiceID === null) {
            throw new RuntimeException('Cannot access invoice PDF without a bound client context and invoice id.');
        }

        return (new Invoices($this->client))->pdf($this->invoiceID);
    }

    public function email(?string $idempotencyKey = null): void
    {
        if ($this->client === null || $this->invoiceID === null) {
            throw new RuntimeException('Cannot email an invoice without a bound client context and invoice id.');
        }

        (new Invoices($this->client))->email($this->invoiceID, $idempotencyKey);
    }

    public function onlineInvoiceUrl(): ?string
    {
        if ($this->client === null || $this->invoiceID === null) {
            throw new RuntimeException('Cannot access the online invoice URL without a bound client context and invoice id.');
        }

        return (new Invoices($this->client))->onlineInvoiceUrl($this->invoiceID);
    }
}
