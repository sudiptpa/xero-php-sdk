<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ManualJournalTotal extends Model
{
    private int|float|null $total = null;

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
            'total' => Field::number(),
        ];
    }
}
