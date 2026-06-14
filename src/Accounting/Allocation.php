<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Accounting\CreditNote\CreditNote;
use Sujip\Xero\Accounting\Invoice\Invoice;
use Sujip\Xero\Accounting\Overpayment\Overpayment;
use Sujip\Xero\Accounting\Prepayment\Prepayment;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\ValidationError;

final class Allocation extends Model
{
    private ?string $allocationID = null;
    private ?float $amount = null;
    private ?string $date = null;
    private ?bool $isDeleted = null;
    private ?Invoice $invoice = null;
    private ?Overpayment $overpayment = null;
    private ?Prepayment $prepayment = null;
    private ?CreditNote $creditNote = null;
    private ?string $statusAttributeString = null;

    /**
     * @var list<ValidationError>
     */
    private array $validationErrors = [];

    public function getAllocationID(): ?string
    {
        return $this->allocationID;
    }

    public function setAllocationID(?string $allocationID): self
    {
        $this->allocationID = $allocationID;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

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

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getOverpayment(): ?Overpayment
    {
        return $this->overpayment;
    }

    public function setOverpayment(?Overpayment $overpayment): self
    {
        $this->overpayment = $overpayment;

        return $this;
    }

    public function getPrepayment(): ?Prepayment
    {
        return $this->prepayment;
    }

    public function setPrepayment(?Prepayment $prepayment): self
    {
        $this->prepayment = $prepayment;

        return $this;
    }

    public function getCreditNote(): ?CreditNote
    {
        return $this->creditNote;
    }

    public function setCreditNote(?CreditNote $creditNote): self
    {
        $this->creditNote = $creditNote;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            // The delete response example uses "AllocationId" while the schema
            // declares "AllocationID" — accept both spellings.
            'AllocationID' => Field::string()->using('setAllocationID'),
            'AllocationId' => Field::string()->using('setAllocationID'),
            'Amount' => Field::number()->using('setAmount'),
            'Date' => Field::string()->using('setDate'),
            'IsDeleted' => Field::boolean()->using('setIsDeleted'),
            'Invoice' => Field::object(Invoice::class)->using('setInvoice'),
            'Overpayment' => Field::object(Overpayment::class)->using('setOverpayment'),
            'Prepayment' => Field::object(Prepayment::class)->using('setPrepayment'),
            'CreditNote' => Field::object(CreditNote::class)->using('setCreditNote'),
            'StatusAttributeString' => Field::string()->using('setStatusAttributeString'),
            'ValidationErrors' => Field::many(ValidationError::class),
        ];
    }
}
