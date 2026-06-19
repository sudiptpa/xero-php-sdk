<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CashflowActivity extends Model
{
    private ?string $name = null;

    private int|float|null $total = null;

    /**
     * @var list<CashflowType>
     */
    private array $cashflowTypes = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return list<CashflowType>
     */
    public function getCashflowTypes(): array
    {
        return $this->cashflowTypes;
    }

    /**
     * @param list<CashflowType> $cashflowTypes
     */
    public function setCashflowTypes(array $cashflowTypes): self
    {
        $this->cashflowTypes = $cashflowTypes;

        return $this;
    }

    public function addCashflowType(CashflowType $cashflowType): self
    {
        $this->cashflowTypes[] = $cashflowType;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'name' => Field::string(),
            'total' => Field::number(),
            'cashflowTypes' => Field::many(CashflowType::class),
        ];
    }
}
