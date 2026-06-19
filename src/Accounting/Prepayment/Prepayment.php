<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Prepayment;

use Sujip\Xero\Accounting\Allocation;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\Payment\Payment;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Prepayment extends Model
{
    private ?string $prepaymentID = null;

    private ?string $type = null;

    private ?Contact $contact = null;

    private ?string $date = null;

    private ?string $status = null;

    private ?string $lineAmountTypes = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    private int|float|null $subTotal = null;

    private int|float|null $totalTax = null;

    private int|float|null $total = null;

    private ?string $reference = null;

    private ?string $invoiceNumber = null;

    private ?string $updatedDateUTC = null;

    private ?string $currencyCode = null;

    private ?string $brandingThemeID = null;

    private int|float|null $currencyRate = null;

    private int|float|null $remainingCredit = null;

    /**
     * @var list<Allocation>
     */
    private array $allocations = [];

    /**
     * @var list<Payment>
     */
    private array $payments = [];

    private int|float|null $appliedAmount = null;

    private ?bool $hasAttachments = null;

    /**
     * @var list<AttachmentDetail>
     */
    private array $attachments = [];

    public function getPrepaymentID(): ?string
    {
        return $this->prepaymentID;
    }

    public function setPrepaymentID(?string $prepaymentID): self
    {
        $this->prepaymentID = $prepaymentID;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

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

    public function getLineAmountTypes(): ?string
    {
        return $this->lineAmountTypes;
    }

    public function setLineAmountTypes(?string $lineAmountTypes): self
    {
        $this->lineAmountTypes = $lineAmountTypes;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

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

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

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

    public function getBrandingThemeID(): ?string
    {
        return $this->brandingThemeID;
    }

    public function setBrandingThemeID(?string $brandingThemeID): self
    {
        $this->brandingThemeID = $brandingThemeID;

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

    public function getAppliedAmount(): int|float|null
    {
        return $this->appliedAmount;
    }

    public function setAppliedAmount(int|float|null $appliedAmount): self
    {
        $this->appliedAmount = $appliedAmount;

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
            'PrepaymentID' => Field::string(),
            'Type' => Field::string(),
            'Contact' => Field::object(Contact::class),
            'Date' => Field::string(),
            'Status' => Field::string(),
            'LineAmountTypes' => Field::string(),
            'LineItems' => Field::many(LineItem::class),
            'SubTotal' => Field::number(),
            'TotalTax' => Field::number(),
            'Total' => Field::number(),
            'Reference' => Field::string(),
            'InvoiceNumber' => Field::string(),
            'UpdatedDateUTC' => Field::string(),
            'CurrencyCode' => Field::string(),
            'BrandingThemeID' => Field::string(),
            'CurrencyRate' => Field::number(),
            'RemainingCredit' => Field::number(),
            'Allocations' => Field::many(Allocation::class),
            'Payments' => Field::many(Payment::class),
            'AppliedAmount' => Field::number(),
            'HasAttachments' => Field::boolean(),
            'Attachments' => Field::many(AttachmentDetail::class),
        ];
    }
}
