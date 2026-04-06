<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class StatutoryDeduction extends Model
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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'StatutoryDeductionID' => Field::string()->using('setStatutoryDeductionID'),
            'Name' => Field::string()->using('setName'),
        ];
    }
}
