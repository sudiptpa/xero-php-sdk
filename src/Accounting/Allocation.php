<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Accounting\Invoice\Invoice;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Allocation extends Model
{
    private ?string $allocationID = null;
    private ?float $amount = null;
    private ?string $date = null;
    private ?bool $isDeleted = null;
    private ?Invoice $invoice = null;

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
        ];
    }
}
