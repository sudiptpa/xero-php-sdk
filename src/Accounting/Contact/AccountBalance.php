<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class AccountBalance extends Model
{
    private int|float|null $outstanding = null;

    private int|float|null $overdue = null;

    public function getOutstanding(): int|float|null
    {
        return $this->outstanding;
    }

    public function setOutstanding(int|float|null $outstanding): self
    {
        $this->outstanding = $outstanding;

        return $this;
    }

    public function getOverdue(): int|float|null
    {
        return $this->overdue;
    }

    public function setOverdue(int|float|null $overdue): self
    {
        $this->overdue = $overdue;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Outstanding' => Field::number(),
            'Overdue' => Field::number(),
        ];
    }
}
