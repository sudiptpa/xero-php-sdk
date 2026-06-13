<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class TrialBalanceEntry extends Model
{
    private int|float|null $value = null;

    private ?string $entryType = null;

    public function getValue(): int|float|null
    {
        return $this->value;
    }

    public function setValue(int|float|null $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getEntryType(): ?string
    {
        return $this->entryType;
    }

    public function setEntryType(?string $entryType): self
    {
        $this->entryType = $entryType;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'value' => Field::number(),
            'entryType' => Field::string(),
        ];
    }
}
