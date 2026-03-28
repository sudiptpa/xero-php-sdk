<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\LeaveType;

final class LeaveType
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
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
