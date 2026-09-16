<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Reimbursement extends Model
{
    public function __construct(
        private ?string $reimbursementID = null,
        private ?string $name = null,
        private ?string $accountID = null,
        private ?bool $currentRecord = null,
        private ?string $reimbursementCategory = null,
        private ?string $calculationType = null,
        private ?string $standardAmount = null,
        private ?string $standardTypeOfUnits = null,
        private ?float $standardRatePerUnit = null,
    ) {
    }

    public function getReimbursementID(): ?string
    {
        return $this->reimbursementID;
    }

    public function setReimbursementID(?string $reimbursementID): self
    {
        $this->reimbursementID = $reimbursementID;

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

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }

    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;

        return $this;
    }

    public function getCurrentRecord(): ?bool
    {
        return $this->currentRecord;
    }

    public function setCurrentRecord(?bool $currentRecord): self
    {
        $this->currentRecord = $currentRecord;

        return $this;
    }

    public function getReimbursementCategory(): ?string
    {
        return $this->reimbursementCategory;
    }

    public function setReimbursementCategory(?string $reimbursementCategory): self
    {
        $this->reimbursementCategory = $reimbursementCategory;

        return $this;
    }

    public function getCalculationType(): ?string
    {
        return $this->calculationType;
    }

    public function setCalculationType(?string $calculationType): self
    {
        $this->calculationType = $calculationType;

        return $this;
    }

    public function getStandardAmount(): ?string
    {
        return $this->standardAmount;
    }

    public function setStandardAmount(?string $standardAmount): self
    {
        $this->standardAmount = $standardAmount;

        return $this;
    }

    public function getStandardTypeOfUnits(): ?string
    {
        return $this->standardTypeOfUnits;
    }

    public function setStandardTypeOfUnits(?string $standardTypeOfUnits): self
    {
        $this->standardTypeOfUnits = $standardTypeOfUnits;

        return $this;
    }

    public function getStandardRatePerUnit(): ?float
    {
        return $this->standardRatePerUnit;
    }

    public function setStandardRatePerUnit(null|float|int $standardRatePerUnit): self
    {
        $this->standardRatePerUnit = $standardRatePerUnit === null ? null : (float) $standardRatePerUnit;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'reimbursementID' => Field::string()->using('setReimbursementID'),
            'name' => Field::string()->using('setName'),
            'accountID' => Field::string()->using('setAccountID'),
            'currentRecord' => Field::boolean()->using('setCurrentRecord'),
            'reimbursementCategory' => Field::string()->using('setReimbursementCategory'),
            'calculationType' => Field::string()->using('setCalculationType'),
            'standardAmount' => Field::string()->using('setStandardAmount'),
            'standardTypeOfUnits' => Field::string()->using('setStandardTypeOfUnits'),
            'standardRatePerUnit' => Field::number()->using('setStandardRatePerUnit'),
        ];
    }
}
