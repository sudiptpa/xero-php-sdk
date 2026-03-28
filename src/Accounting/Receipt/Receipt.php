<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Client;

final class Receipt
{
    private ?string $receiptID = null;

    private ?string $receiptNumber = null;

    private ?string $status = null;

    private int|float|null $total = null;

    private ?Contact $contact = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getReceiptID(): ?string
    {
        return $this->receiptID;
    }

    public function setReceiptID(?string $receiptID): self
    {
        $this->receiptID = $receiptID;

        return $this;
    }

    public function getReceiptNumber(): ?string
    {
        return $this->receiptNumber;
    }

    public function setReceiptNumber(?string $receiptNumber): self
    {
        $this->receiptNumber = $receiptNumber;

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

    public function attachments(): Attachments
    {
        if ($this->client === null || $this->receiptID === null) {
            throw new RuntimeException('Cannot access receipt attachments without a bound client context and receipt id.');
        }

        return (new Receipts($this->client))->attachments($this->receiptID);
    }

    public function history(): History
    {
        if ($this->client === null || $this->receiptID === null) {
            throw new RuntimeException('Cannot access receipt history without a bound client context and receipt id.');
        }

        return (new Receipts($this->client))->history($this->receiptID);
    }
}
