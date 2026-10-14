<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ReimbursementLine extends Model
{
    private ?string $reimbursementTypeID = null;

    private ?string $description = null;

    private ?float $amount = null;

    public function getReimbursementTypeID(): ?string
    {
        return $this->reimbursementTypeID;
    }

    public function setReimbursementTypeID(?string $reimbursementTypeID): self
    {
        $this->reimbursementTypeID = $reimbursementTypeID;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'reimbursementTypeID' => Field::string(),
            'description' => Field::string(),
            'amount' => Field::number(),
        ];
    }
}
