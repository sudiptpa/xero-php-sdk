<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

final class StatutoryDeduction
{
    /**
     */
    public function __construct(
        private ?string $statutoryDeductionID = null,
        private ?string $name = null,
    ) {
    }

    public function getStatutoryDeductionID(): ?string { return $this->statutoryDeductionID; }
    public function setStatutoryDeductionID(?string $statutoryDeductionID): self { $this->statutoryDeductionID = $statutoryDeductionID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
