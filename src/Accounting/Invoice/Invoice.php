<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\CreditNote\CreditNote;
use Sujip\Xero\Accounting\Overpayment\Overpayment;
use Sujip\Xero\Accounting\Payment\Payment;
use Sujip\Xero\Accounting\Prepayment\Prepayment;
use Sujip\Xero\Client;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\InvoiceAddress;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;
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

    private ?string $date = null;

    private ?string $dueDate = null;

    private ?string $lineAmountTypes = null;

    private ?string $invoiceNumber = null;

    private ?string $brandingThemeID = null;

    private ?string $url = null;

    private ?string $currencyCode = null;

    private int|float|null $currencyRate = null;

    private ?bool $sentToContact = null;

    private ?string $expectedPaymentDate = null;

    private ?string $plannedPaymentDate = null;

    private int|float|null $cisDeduction = null;

    private int|float|null $cisRate = null;

    private int|float|null $subTotal = null;

    private int|float|null $totalTax = null;

    private int|float|null $total = null;

    private int|float|null $totalDiscount = null;

    private ?string $repeatingInvoiceID = null;

    private ?bool $hasAttachments = null;

    private ?bool $isDiscounted = null;

    /**
     * @var list<Payment>
     */
    private array $payments = [];

    /**
     * @var list<Prepayment>
     */
    private array $prepayments = [];

    /**
     * @var list<Overpayment>
     */
    private array $overpayments = [];

    private int|float|null $amountDue = null;

    private int|float|null $amountPaid = null;

    private ?string $fullyPaidOnDate = null;

    private int|float|null $amountCredited = null;

    private ?string $updatedDateUTC = null;

    /**
     * @var list<CreditNote>
     */
    private array $creditNotes = [];

    /**
     * @var list<AttachmentDetail>
     */
    private array $attachments = [];

    private ?bool $hasErrors = null;

    private ?string $statusAttributeString = null;

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

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function setInvoiceNumber(?string $invoiceNumber): self
    {
        $this->invoiceNumber = $invoiceNumber;

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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

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

    public function getCurrencyRate(): int|float|null
    {
        return $this->currencyRate;
    }

    public function setCurrencyRate(int|float|null $currencyRate): self
    {
        $this->currencyRate = $currencyRate;

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

    public function getExpectedPaymentDate(): ?string
    {
        return $this->expectedPaymentDate;
    }

    public function setExpectedPaymentDate(?string $expectedPaymentDate): self
    {
        $this->expectedPaymentDate = $expectedPaymentDate;

        return $this;
    }

    public function getPlannedPaymentDate(): ?string
    {
        return $this->plannedPaymentDate;
    }

    public function setPlannedPaymentDate(?string $plannedPaymentDate): self
    {
        $this->plannedPaymentDate = $plannedPaymentDate;

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

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getTotalDiscount(): int|float|null
    {
        return $this->totalDiscount;
    }

    public function setTotalDiscount(int|float|null $totalDiscount): self
    {
        $this->totalDiscount = $totalDiscount;

        return $this;
    }

    public function getRepeatingInvoiceID(): ?string
    {
        return $this->repeatingInvoiceID;
    }

    public function setRepeatingInvoiceID(?string $repeatingInvoiceID): self
    {
        $this->repeatingInvoiceID = $repeatingInvoiceID;

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

    public function getIsDiscounted(): ?bool
    {
        return $this->isDiscounted;
    }

    public function setIsDiscounted(?bool $isDiscounted): self
    {
        $this->isDiscounted = $isDiscounted;

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

    /**
     * @return list<Prepayment>
     */
    public function getPrepayments(): array
    {
        return $this->prepayments;
    }

    public function addPrepayment(Prepayment $prepayment): self
    {
        $this->prepayments[] = $prepayment;

        return $this;
    }

    /**
     * @return list<Overpayment>
     */
    public function getOverpayments(): array
    {
        return $this->overpayments;
    }

    public function addOverpayment(Overpayment $overpayment): self
    {
        $this->overpayments[] = $overpayment;

        return $this;
    }

    public function getAmountDue(): int|float|null
    {
        return $this->amountDue;
    }

    public function setAmountDue(int|float|null $amountDue): self
    {
        $this->amountDue = $amountDue;

        return $this;
    }

    public function getAmountPaid(): int|float|null
    {
        return $this->amountPaid;
    }

    public function setAmountPaid(int|float|null $amountPaid): self
    {
        $this->amountPaid = $amountPaid;

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

    public function getAmountCredited(): int|float|null
    {
        return $this->amountCredited;
    }

    public function setAmountCredited(int|float|null $amountCredited): self
    {
        $this->amountCredited = $amountCredited;

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

    /**
     * @return list<CreditNote>
     */
    public function getCreditNotes(): array
    {
        return $this->creditNotes;
    }

    public function addCreditNote(CreditNote $creditNote): self
    {
        $this->creditNotes[] = $creditNote;

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

    public function getHasErrors(): ?bool
    {
        return $this->hasErrors;
    }

    public function setHasErrors(?bool $hasErrors): self
    {
        $this->hasErrors = $hasErrors;

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
            'InvoiceID' => Field::string(),
            'Status' => Field::string(),
            'Reference' => Field::string(),
            'Type' => Field::string(),
            'Contact' => Field::object(Contact::class),
            'LineItems' => Field::many(LineItem::class),
            'Date' => Field::string(),
            'DueDate' => Field::string(),
            'LineAmountTypes' => Field::string(),
            'InvoiceNumber' => Field::string(),
            'BrandingThemeID' => Field::string(),
            'Url' => Field::string(),
            'CurrencyCode' => Field::string(),
            'CurrencyRate' => Field::number(),
            'SentToContact' => Field::boolean(),
            'ExpectedPaymentDate' => Field::string(),
            'PlannedPaymentDate' => Field::string(),
            'CISDeduction' => Field::number(),
            'CISRate' => Field::number(),
            'SubTotal' => Field::number(),
            'TotalTax' => Field::number(),
            'Total' => Field::number(),
            'TotalDiscount' => Field::number(),
            'RepeatingInvoiceID' => Field::string(),
            'HasAttachments' => Field::boolean(),
            'IsDiscounted' => Field::boolean(),
            'Payments' => Field::many(Payment::class),
            'Prepayments' => Field::many(Prepayment::class),
            'Overpayments' => Field::many(Overpayment::class),
            'AmountDue' => Field::number(),
            'AmountPaid' => Field::number(),
            'FullyPaidOnDate' => Field::string(),
            'AmountCredited' => Field::number(),
            'UpdatedDateUTC' => Field::string(),
            'CreditNotes' => Field::many(CreditNote::class),
            'Attachments' => Field::many(AttachmentDetail::class),
            'HasErrors' => Field::boolean(),
            'StatusAttributeString' => Field::string(),
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

        if ($class === CreditNote::class) {
            return new CreditNote($this->client);
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
            'Date' => $this->getDate(),
            'DueDate' => $this->getDueDate(),
            'LineAmountTypes' => $this->getLineAmountTypes(),
            'InvoiceNumber' => $this->getInvoiceNumber(),
            'BrandingThemeID' => $this->getBrandingThemeID(),
            'Url' => $this->getUrl(),
            'CurrencyCode' => $this->getCurrencyCode(),
            'CurrencyRate' => $this->getCurrencyRate(),
            'SentToContact' => $this->getSentToContact(),
            'ExpectedPaymentDate' => $this->getExpectedPaymentDate(),
            'PlannedPaymentDate' => $this->getPlannedPaymentDate(),
            'RepeatingInvoiceID' => $this->getRepeatingInvoiceID(),
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
