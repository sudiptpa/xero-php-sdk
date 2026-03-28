<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

final class StatutoryLeaveSummary
{
    /**
     */
    public function __construct(
        private ?string $employeeID = null,
        private ?string $units = null,
    ) {
    }

    public function getEmployeeID(): ?string { return $this->employeeID; }
    public function setEmployeeID(?string $employeeID): self { $this->employeeID = $employeeID; return $this; }
    public function getUnits(): ?string { return $this->units; }
    public function setUnits(?string $units): self { $this->units = $units; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
