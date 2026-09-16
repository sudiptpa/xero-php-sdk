<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\LeaveType;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LeaveType extends Model
{
    public function __construct(
        private ?string $leaveID = null,
        private ?string $leaveTypeID = null,
        private ?string $name = null,
        private ?bool $isPaidLeave = null,
        private ?bool $showOnPayslip = null,
        private ?string $updatedDateUTC = null,
        private ?bool $isActive = null,
        private ?bool $isStatutoryLeave = null,
    ) {
    }

    public function getLeaveID(): ?string
    {
        return $this->leaveID;
    }

    public function setLeaveID(?string $leaveID): self
    {
        $this->leaveID = $leaveID;

        return $this;
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

    public function getIsStatutoryLeave(): ?bool
    {
        return $this->isStatutoryLeave;
    }

    public function setIsStatutoryLeave(?bool $isStatutoryLeave): self
    {
        $this->isStatutoryLeave = $isStatutoryLeave;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'leaveID' => Field::string()->using('setLeaveID'),
            'leaveTypeID' => Field::string()->using('setLeaveTypeID'),
            'name' => Field::string()->using('setName'),
            'isPaidLeave' => Field::boolean()->using('setIsPaidLeave'),
            'showOnPayslip' => Field::boolean()->using('setShowOnPayslip'),
            'updatedDateUTC' => Field::string()->using('setUpdatedDateUTC'),
            'isActive' => Field::boolean()->using('setIsActive'),
            'isStatutoryLeave' => Field::boolean()->using('setIsStatutoryLeave'),
        ];
    }
}
