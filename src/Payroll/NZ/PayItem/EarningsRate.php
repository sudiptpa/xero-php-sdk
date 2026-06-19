<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayItem;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EarningsRate extends Model implements SerializesRequest
{
    private ?string $earningsRateID = null;

    private ?string $name = null;

    private ?string $earningsType = null;

    private ?string $rateType = null;

    private ?string $typeOfUnits = null;

    private ?bool $currentRecord = null;

    private ?string $expenseAccountID = null;

    private ?float $ratePerUnit = null;

    private ?float $multipleOfOrdinaryEarningsRate = null;

    private ?float $fixedAmount = null;

    public function getEarningsRateID(): ?string
    {
        return $this->earningsRateID;
    }

    public function setEarningsRateID(?string $earningsRateID): self
    {
        $this->earningsRateID = $earningsRateID;

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

    public function getEarningsType(): ?string
    {
        return $this->earningsType;
    }

    public function setEarningsType(?string $earningsType): self
    {
        $this->earningsType = $earningsType;

        return $this;
    }

    public function getRateType(): ?string
    {
        return $this->rateType;
    }

    public function setRateType(?string $rateType): self
    {
        $this->rateType = $rateType;

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

    public function getCurrentRecord(): ?bool
    {
        return $this->currentRecord;
    }

    public function setCurrentRecord(?bool $currentRecord): self
    {
        $this->currentRecord = $currentRecord;

        return $this;
    }

    public function getExpenseAccountID(): ?string
    {
        return $this->expenseAccountID;
    }

    public function setExpenseAccountID(?string $expenseAccountID): self
    {
        $this->expenseAccountID = $expenseAccountID;

        return $this;
    }

    public function getRatePerUnit(): ?float
    {
        return $this->ratePerUnit;
    }

    public function setRatePerUnit(?float $ratePerUnit): self
    {
        $this->ratePerUnit = $ratePerUnit;

        return $this;
    }

    public function getMultipleOfOrdinaryEarningsRate(): ?float
    {
        return $this->multipleOfOrdinaryEarningsRate;
    }

    public function setMultipleOfOrdinaryEarningsRate(?float $multipleOfOrdinaryEarningsRate): self
    {
        $this->multipleOfOrdinaryEarningsRate = $multipleOfOrdinaryEarningsRate;

        return $this;
    }

    public function getFixedAmount(): ?float
    {
        return $this->fixedAmount;
    }

    public function setFixedAmount(?float $fixedAmount): self
    {
        $this->fixedAmount = $fixedAmount;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'earningsRateID' => Field::string(),
            'name' => Field::string(),
            'earningsType' => Field::string(),
            'rateType' => Field::string(),
            'typeOfUnits' => Field::string(),
            'currentRecord' => Field::boolean(),
            'expenseAccountID' => Field::string(),
            'ratePerUnit' => Field::number(),
            'multipleOfOrdinaryEarningsRate' => Field::number(),
            'fixedAmount' => Field::number(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'earningsRateID' => $this->getEarningsRateID(),
            'name' => $this->getName(),
            'earningsType' => $this->getEarningsType(),
            'rateType' => $this->getRateType(),
            'typeOfUnits' => $this->getTypeOfUnits(),
            'currentRecord' => $this->getCurrentRecord(),
            'expenseAccountID' => $this->getExpenseAccountID(),
            'ratePerUnit' => $this->getRatePerUnit(),
            'multipleOfOrdinaryEarningsRate' => $this->getMultipleOfOrdinaryEarningsRate(),
            'fixedAmount' => $this->getFixedAmount(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
