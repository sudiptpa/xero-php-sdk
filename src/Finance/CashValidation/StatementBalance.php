<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class StatementBalance extends Model
{
    private int|float|null $value = null;

    private ?string $type = null;

    public function getValue(): int|float|null
    {
        return $this->value;
    }

    public function setValue(int|float|null $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'value' => Field::number(),
            'type' => Field::string(),
        ];
    }
}
