<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Amount extends Model
{
    private ?string $currency = null;

    private int|float|null $value = null;

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getValue(): int|float|null
    {
        return $this->value;
    }

    public function setValue(int|float|null $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'currency' => Field::string(),
            'value' => Field::number(),
        ];
    }
}
