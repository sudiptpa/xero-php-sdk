<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\LeaveType;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LeaveType extends Model
{
    public function __construct(
        private ?string $leaveTypeID = null,
        private ?string $name = null,
        private ?bool $isPaidLeave = null,
        private ?bool $showOnPayslip = null,
        private ?string $updatedDateUTC = null,
        private ?bool $isActive = null,
        private ?string $typeOfUnits = null,
        private ?string $typeOfUnitsToAccrue = null,
    ) {
    }

    public function getLeaveTypeID(): ?string
    {
        return $this->leaveTypeID;
    }

    public function setLeaveTypeID(?string $leaveTypeID): self
    {
        $this->leaveTypeID = $leaveTypeID;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsPaidLeave(): ?bool
    {
        return $this->isPaidLeave;
    }

    public function setIsPaidLeave(?bool $isPaidLeave): self
    {
        $this->isPaidLeave = $isPaidLeave;

        return $this;
    }

    public function getShowOnPayslip(): ?bool
    {
        return $this->showOnPayslip;
    }

    public function setShowOnPayslip(?bool $showOnPayslip): self
    {
        $this->showOnPayslip = $showOnPayslip;

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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getTypeOfUnits(): ?string
    {
        return $this->typeOfUnits;
    }

    public function setTypeOfUnits(?string $typeOfUnits): self
    {
        $this->typeOfUnits = $typeOfUnits;

        return $this;
    }

    public function getTypeOfUnitsToAccrue(): ?string
    {
        return $this->typeOfUnitsToAccrue;
    }

    public function setTypeOfUnitsToAccrue(?string $typeOfUnitsToAccrue): self
    {
        $this->typeOfUnitsToAccrue = $typeOfUnitsToAccrue;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'leaveTypeID' => Field::string()->using('setLeaveTypeID'),
            'name' => Field::string()->using('setName'),
            'isPaidLeave' => Field::boolean()->using('setIsPaidLeave'),
            'showOnPayslip' => Field::boolean()->using('setShowOnPayslip'),
            'updatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'isActive' => Field::boolean()->using('setIsActive'),
            'typeOfUnits' => Field::string()->using('setTypeOfUnits'),
            'typeOfUnitsToAccrue' => Field::string()->using('setTypeOfUnitsToAccrue'),
        ];
    }
}
