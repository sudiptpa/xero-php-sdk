<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayItem;

use Sujip\Xero\Support\Contracts\SerializesRequest;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Superannuation extends Model implements SerializesRequest
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $category = null;

    private ?string $liabilityAccountId = null;

    private ?string $expenseAccountId = null;

    private ?string $calculationTypeNZ = null;

    private ?float $standardAmount = null;

    private ?float $percentage = null;

    private ?float $companyMax = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLiabilityAccountId(): ?string
    {
        return $this->liabilityAccountId;
    }

    public function setLiabilityAccountId(?string $liabilityAccountId): self
    {
        $this->liabilityAccountId = $liabilityAccountId;

        return $this;
    }

    public function getExpenseAccountId(): ?string
    {
        return $this->expenseAccountId;
    }

    public function setExpenseAccountId(?string $expenseAccountId): self
    {
        $this->expenseAccountId = $expenseAccountId;

        return $this;
    }

    public function getCalculationTypeNZ(): ?string
    {
        return $this->calculationTypeNZ;
    }

    public function setCalculationTypeNZ(?string $calculationTypeNZ): self
    {
        $this->calculationTypeNZ = $calculationTypeNZ;

        return $this;
    }

    public function getStandardAmount(): ?float
    {
        return $this->standardAmount;
    }

    public function setStandardAmount(?float $standardAmount): self
    {
        $this->standardAmount = $standardAmount;

        return $this;
    }

    public function getPercentage(): ?float
    {
        return $this->percentage;
    }

    public function setPercentage(?float $percentage): self
    {
        $this->percentage = $percentage;

        return $this;
    }

    public function getCompanyMax(): ?float
    {
        return $this->companyMax;
    }

    public function setCompanyMax(?float $companyMax): self
    {
        $this->companyMax = $companyMax;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'id' => Field::string(),
            'name' => Field::string(),
            'category' => Field::string(),
            'liabilityAccountId' => Field::string(),
            'expenseAccountId' => Field::string(),
            'calculationTypeNZ' => Field::string(),
            'standardAmount' => Field::number(),
            'percentage' => Field::number(),
            'companyMax' => Field::number(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'id' => $this->getId(),
            'name' => $this->getName(),
            'category' => $this->getCategory(),
            'liabilityAccountId' => $this->getLiabilityAccountId(),
            'expenseAccountId' => $this->getExpenseAccountId(),
            'calculationTypeNZ' => $this->getCalculationTypeNZ(),
            'standardAmount' => $this->getStandardAmount(),
            'percentage' => $this->getPercentage(),
            'companyMax' => $this->getCompanyMax(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
