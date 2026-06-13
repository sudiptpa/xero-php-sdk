<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BalanceSheet extends Model
{
    private ?string $balanceDate = null;

    private ?BalanceSheetAccountGroup $asset = null;

    private ?BalanceSheetAccountGroup $liability = null;

    private ?BalanceSheetAccountGroup $equity = null;

    public function getBalanceDate(): ?string
    {
        return $this->balanceDate;
    }

    public function setBalanceDate(?string $balanceDate): self
    {
        $this->balanceDate = $balanceDate;

        return $this;
    }

    public function getAsset(): ?BalanceSheetAccountGroup
    {
        return $this->asset;
    }

    public function setAsset(?BalanceSheetAccountGroup $asset): self
    {
        $this->asset = $asset;

        return $this;
    }

    public function getLiability(): ?BalanceSheetAccountGroup
    {
        return $this->liability;
    }

    public function setLiability(?BalanceSheetAccountGroup $liability): self
    {
        $this->liability = $liability;

        return $this;
    }

    public function getEquity(): ?BalanceSheetAccountGroup
    {
        return $this->equity;
    }

    public function setEquity(?BalanceSheetAccountGroup $equity): self
    {
        $this->equity = $equity;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'balanceDate' => Field::string(),
            'asset' => Field::object(BalanceSheetAccountGroup::class),
            'liability' => Field::object(BalanceSheetAccountGroup::class),
            'equity' => Field::object(BalanceSheetAccountGroup::class),
        ];
    }
}
