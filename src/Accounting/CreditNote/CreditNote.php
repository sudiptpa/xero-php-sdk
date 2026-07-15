<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use RuntimeException;
use Sujip\Xero\Accounting\Allocation;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\Payment\Payment;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\InvoiceAddress;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class CreditNote extends Model implements SerializesRequest
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

    private ?string $date = null;

    private ?string $dueDate = null;

    private ?string $lineAmountTypes = null;

    private int|float|null $subTotal = null;

    private int|float|null $totalTax = null;

    private int|float|null $cisDeduction = null;

    private int|float|null $cisRate = null;

    private ?string $updatedDateUTC = null;

    private ?string $updatedDateUTCString = null;

    private ?string $currencyCode = null;

    private ?string $fullyPaidOnDate = null;

    private ?string $creditNoteNumber = null;

    private ?bool $sentToContact = null;

    private int|float|null $currencyRate = null;

    private int|float|null $remainingCredit = null;

    /**
     * @var list<Allocation>
     */
    private array $allocations = [];

    private int|float|null $appliedAmount = null;

    /**
     * @var list<Payment>
     */
    private array $payments = [];

    private ?string $brandingThemeID = null;

    private ?string $statusAttributeString = null;

    private ?bool $hasAttachments = null;

    private ?bool $hasErrors = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    /**
     * @var list<ValidationError>
     */
    private array $warnings = [];

    /**
     * @var list<InvoiceAddress>
     */
    private array $invoiceAddresses = [];

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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    public function setDueDate(?string $dueDate): self
    {
        $this->dueDate = $dueDate;

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

    public function getCISDeduction(): int|float|null
    {
        return $this->cisDeduction;
    }

    public function setCISDeduction(int|float|null $cisDeduction): self
    {
        $this->cisDeduction = $cisDeduction;

        return $this;
    }

    public function getCISRate(): int|float|null
    {
        return $this->cisRate;
    }

    public function setCISRate(int|float|null $cisRate): self
    {
        $this->cisRate = $cisRate;

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

    public function getUpdatedDateUTCString(): ?string
    {
        return $this->updatedDateUTCString;
    }

    public function setUpdatedDateUTCString(?string $updatedDateUTCString): self
    {
        $this->updatedDateUTCString = $updatedDateUTCString;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(?string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getFullyPaidOnDate(): ?string
    {
        return $this->fullyPaidOnDate;
    }

    public function setFullyPaidOnDate(?string $fullyPaidOnDate): self
    {
        $this->fullyPaidOnDate = $fullyPaidOnDate;

        return $this;
    }

    public function getCreditNoteNumber(): ?string
    {
        return $this->creditNoteNumber;
    }

    public function setCreditNoteNumber(?string $creditNoteNumber): self
    {
        $this->creditNoteNumber = $creditNoteNumber;

        return $this;
    }

    public function getSentToContact(): ?bool
    {
        return $this->sentToContact;
    }

    public function setSentToContact(?bool $sentToContact): self
    {
        $this->sentToContact = $sentToContact;

        return $this;
    }

    public function getCurrencyRate(): int|float|null
    {
        return $this->currencyRate;
    }

    public function setCurrencyRate(int|float|null $currencyRate): self
    {
        $this->currencyRate = $currencyRate;

        return $this;
    }

    public function getRemainingCredit(): int|float|null
    {
        return $this->remainingCredit;
    }

    public function setRemainingCredit(int|float|null $remainingCredit): self
    {
        $this->remainingCredit = $remainingCredit;

        return $this;
    }

    /**
     * @return list<Allocation>
     */
    public function getAllocations(): array
    {
        return $this->allocations;
    }

    public function addAllocation(Allocation $allocation): self
    {
        $this->allocations[] = $allocation;

        return $this;
    }

    public function getAppliedAmount(): int|float|null
    {
        return $this->appliedAmount;
    }

    public function setAppliedAmount(int|float|null $appliedAmount): self
    {
        $this->appliedAmount = $appliedAmount;

        return $this;
    }

    /**
     * @return list<Payment>
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        $this->payments[] = $payment;

        return $this;
    }

    public function getBrandingThemeID(): ?string
    {
        return $this->brandingThemeID;
    }

    public function setBrandingThemeID(?string $brandingThemeID): self
    {
        $this->brandingThemeID = $brandingThemeID;

        return $this;
    }

    public function getStatusAttributeString(): ?string
    {
        return $this->statusAttributeString;
    }

    public function setStatusAttributeString(?string $statusAttributeString): self
    {
        $this->statusAttributeString = $statusAttributeString;

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

    public function getHasErrors(): ?bool
    {
        return $this->hasErrors;
    }

    public function setHasErrors(?bool $hasErrors): self
    {
        $this->hasErrors = $hasErrors;

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
     * @return list<InvoiceAddress>
     */
    public function getInvoiceAddresses(): array
    {
        return $this->invoiceAddresses;
    }

    public function addInvoiceAddress(InvoiceAddress $invoiceAddress): self
    {
        $this->invoiceAddresses[] = $invoiceAddress;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'CreditNoteID' => Field::string(),
            'Type' => Field::string(),
            'Status' => Field::string(),
            'Reference' => Field::string(),
            'Total' => Field::number(),
            'Contact' => Field::object(Contact::class),
            'LineItems' => Field::many(LineItem::class),
            'Date' => Field::string(),
            'DueDate' => Field::string(),
            'LineAmountTypes' => Field::string(),
            'SubTotal' => Field::number(),
            'TotalTax' => Field::number(),
            'CISDeduction' => Field::number(),
            'CISRate' => Field::number(),
            'UpdatedDateUTC' => Field::string(),
            'UpdatedDateUTCString' => Field::string(),
            'CurrencyCode' => Field::string(),
            'FullyPaidOnDate' => Field::string(),
            'CreditNoteNumber' => Field::string(),
            'SentToContact' => Field::boolean(),
            'CurrencyRate' => Field::number(),
            'RemainingCredit' => Field::number(),
            'Allocations' => Field::many(Allocation::class),
            'AppliedAmount' => Field::number(),
            'Payments' => Field::many(Payment::class),
            'BrandingThemeID' => Field::string(),
            'StatusAttributeString' => Field::string(),
            'HasAttachments' => Field::boolean(),
            'HasErrors' => Field::boolean(),
            'ValidationErrors' => Field::many(ValidationError::class),
            'Warnings' => Field::many(ValidationError::class),
            'InvoiceAddresses' => Field::many(InvoiceAddress::class),
        ];
    }

    protected function newDefinitionInstance(string $class): object
    {
        if ($class === Contact::class) {
            return new Contact($this->client);
        }

        if ($class === Payment::class) {
            return new Payment($this->client);
        }

        return parent::newDefinitionInstance($class);
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
            'Date' => $this->getDate(),
            'DueDate' => $this->getDueDate(),
            'LineAmountTypes' => $this->getLineAmountTypes(),
            'CurrencyCode' => $this->getCurrencyCode(),
            'CurrencyRate' => $this->getCurrencyRate(),
            'CreditNoteNumber' => $this->getCreditNoteNumber(),
            'BrandingThemeID' => $this->getBrandingThemeID(),
            'InvoiceAddresses' => array_map(
                static fn (InvoiceAddress $invoiceAddress): array => $invoiceAddress->toRequest(),
                $this->getInvoiceAddresses()
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
