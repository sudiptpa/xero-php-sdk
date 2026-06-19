<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class EarningsTemplate extends Model implements SerializesRequest
{
    private ?string $payTemplateEarningID = null;

    private ?float $ratePerUnit = null;

    private ?float $numberOfUnits = null;

    private ?float $fixedAmount = null;

    private ?string $earningsRateID = null;

    private ?string $name = null;

    public function getPayTemplateEarningID(): ?string
    {
        return $this->payTemplateEarningID;
    }

    public function setPayTemplateEarningID(?string $payTemplateEarningID): self
    {
        $this->payTemplateEarningID = $payTemplateEarningID;

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

    public function getNumberOfUnits(): ?float
    {
        return $this->numberOfUnits;
    }

    public function setNumberOfUnits(?float $numberOfUnits): self
    {
        $this->numberOfUnits = $numberOfUnits;

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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'payTemplateEarningID' => Field::string(),
            'ratePerUnit' => Field::number(),
            'numberOfUnits' => Field::number(),
            'fixedAmount' => Field::number(),
            'earningsRateID' => Field::string(),
            'name' => Field::string(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'payTemplateEarningID' => $this->getPayTemplateEarningID(),
            'ratePerUnit' => $this->getRatePerUnit(),
            'numberOfUnits' => $this->getNumberOfUnits(),
            'fixedAmount' => $this->getFixedAmount(),
            'earningsRateID' => $this->getEarningsRateID(),
            'name' => $this->getName(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
