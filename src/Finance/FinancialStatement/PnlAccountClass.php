<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PnlAccountClass extends Model
{
    private int|float|null $total = null;

    /**
     * @var list<PnlAccountType>
     */
    private array $accountTypes = [];

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
     * @return list<PnlAccountType>
     */
    public function getAccountTypes(): array
    {
        return $this->accountTypes;
    }

    /**
     * @param list<PnlAccountType> $accountTypes
     */
    public function setAccountTypes(array $accountTypes): self
    {
        $this->accountTypes = $accountTypes;

        return $this;
    }

    public function addAccountType(PnlAccountType $accountType): self
    {
        $this->accountTypes[] = $accountType;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'total' => Field::number(),
            'accountTypes' => Field::many(PnlAccountType::class),
        ];
    }
}
