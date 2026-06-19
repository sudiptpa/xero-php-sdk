<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BalanceSheetAccountGroup extends Model
{
    /**
     * @var list<BalanceSheetAccountType>
     */
    private array $accountTypes = [];

    private int|float|null $total = null;

    /**
     * @return list<BalanceSheetAccountType>
     */
    public function getAccountTypes(): array
    {
        return $this->accountTypes;
    }

    /**
     * @param list<BalanceSheetAccountType> $accountTypes
     */
    public function setAccountTypes(array $accountTypes): self
    {
        $this->accountTypes = $accountTypes;

        return $this;
    }

    public function addAccountType(BalanceSheetAccountType $accountType): self
    {
        $this->accountTypes[] = $accountType;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'accountTypes' => Field::many(BalanceSheetAccountType::class),
            'total' => Field::number(),
        ];
    }
}
