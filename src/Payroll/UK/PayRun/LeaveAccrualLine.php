<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LeaveAccrualLine extends Model
{
    private ?string $leaveTypeID = null;

    private ?float $numberOfUnits = null;

    public function getLeaveTypeID(): ?string
    {
        return $this->leaveTypeID;
    }

    public function setLeaveTypeID(?string $leaveTypeID): self
    {
        $this->leaveTypeID = $leaveTypeID;

        return $this;
    }

    public function getNumberOfUnits(): ?float
    {
        return $this->numberOfUnits;
    }

    public function setNumberOfUnits(?float $numberOfUnits): self
    {
        $this->numberOfUnits = $numberOfUnits;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'leaveTypeID' => Field::string(),
            'numberOfUnits' => Field::number(),
        ];
    }
}
