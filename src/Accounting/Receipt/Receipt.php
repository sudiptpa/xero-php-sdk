<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\User\User;
use Sujip\Xero\Client;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class Receipt extends Model
{
    private ?string $receiptID = null;

    private ?string $receiptNumber = null;

    private ?string $status = null;

    private int|float|null $total = null;

    private ?Contact $contact = null;

    private ?string $date = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    private ?User $user = null;

    private ?string $reference = null;

    private ?string $lineAmountTypes = null;

    private int|float|null $subTotal = null;

    private int|float|null $totalTax = null;

    private ?string $updatedDateUTC = null;

    private ?bool $hasAttachments = null;

    private ?string $url = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    /**
     * @var list<ValidationError>
     */
    private array $warnings = [];

    /**
     * @var list<AttachmentDetail>
     */
    private array $attachments = [];

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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return list<LineItem>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems[] = $lineItem;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getLineAmountTypes(): ?string
    {
        return $this->lineAmountTypes;
    }

    public function setLineAmountTypes(?string $lineAmountTypes): self
    {
        $this->lineAmountTypes = $lineAmountTypes;

        return $this;
    }

    public function getSubTotal(): int|float|null
    {
        return $this->subTotal;
    }

    public function setSubTotal(int|float|null $subTotal): self
    {
        $this->subTotal = $subTotal;

        return $this;
    }

    public function getTotalTax(): int|float|null
    {
        return $this->totalTax;
    }

    public function setTotalTax(int|float|null $totalTax): self
    {
        $this->totalTax = $totalTax;

        return $this;
    }

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

        return $this;
    }

    public function getHasAttachments(): ?bool
    {
        return $this->hasAttachments;
    }

    public function setHasAttachments(?bool $hasAttachments): self
    {
        $this->hasAttachments = $hasAttachments;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return list<ValidationError>
     */
    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function addValidationError(ValidationError $validationError): self
    {
        $this->validationErrors[] = $validationError;

        return $this;
    }

    /**
     * @return list<ValidationError>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function addWarning(ValidationError $warning): self
    {
        $this->warnings[] = $warning;

        return $this;
    }

    /**
     * @return list<AttachmentDetail>
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    public function addAttachment(AttachmentDetail $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ReceiptID' => Field::string(),
            'ReceiptNumber' => Field::string(),
            'Status' => Field::string(),
            'Total' => Field::number(),
            'Contact' => Field::object(Contact::class),
            'Date' => Field::string(),
            'LineItems' => Field::many(LineItem::class),
            'User' => Field::object(User::class),
            'Reference' => Field::string(),
            'LineAmountTypes' => Field::string(),
            'SubTotal' => Field::number(),
            'TotalTax' => Field::number(),
            'UpdatedDateUTC' => Field::string(),
            'HasAttachments' => Field::boolean(),
            'Url' => Field::string(),
            'ValidationErrors' => Field::many(ValidationError::class),
            'Warnings' => Field::many(ValidationError::class),
            'Attachments' => Field::many(AttachmentDetail::class),
        ];
    }

    protected function newDefinitionInstance(string $class): object
    {
        if ($class === Contact::class) {
            return new Contact($this->client);
        }

        return parent::newDefinitionInstance($class);
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
