<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CourtOrderLine extends Model
{
    private ?string $courtOrderTypeID = null;

    private ?float $amount = null;

    public function getCourtOrderTypeID(): ?string
    {
        return $this->courtOrderTypeID;
    }

    public function setCourtOrderTypeID(?string $courtOrderTypeID): self
    {
        $this->courtOrderTypeID = $courtOrderTypeID;

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
            'courtOrderTypeID' => Field::string(),
            'amount' => Field::number(),
        ];
    }
}
