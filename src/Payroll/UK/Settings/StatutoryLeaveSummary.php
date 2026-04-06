<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class StatutoryLeaveSummary extends Model
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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'EmployeeID' => Field::string()->using('setEmployeeID'),
            'Units' => Field::string()->using('setUnits'),
        ];
    }
}
