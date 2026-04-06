<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\LeaveType;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LeaveType extends Model
{
    /**
     */
    public function __construct(
        private ?string $leaveTypeID = null,
        private ?string $name = null,
        private ?bool $isActive = null,
    ) {
    }

    public function getLeaveTypeID(): ?string { return $this->leaveTypeID; }
    public function setLeaveTypeID(?string $leaveTypeID): self { $this->leaveTypeID = $leaveTypeID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }
    public function getIsActive(): ?bool { return $this->isActive; }
    public function setIsActive(?bool $isActive): self { $this->isActive = $isActive; return $this; }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'LeaveTypeID' => Field::string()->using('setLeaveTypeID'),
            'Name' => Field::string()->using('setName'),
            'IsActive' => Field::boolean()->using('setIsActive'),
        ];
    }
}
