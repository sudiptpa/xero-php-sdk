<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ReportCell extends Model
{
    private ?string $value = null;

    /**
     * @var list<ReportAttribute>
     */
    private array $attributes = [];

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return list<ReportAttribute>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function addAttribute(ReportAttribute $attribute): self
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Value' => Field::string(),
            'Attributes' => Field::many(ReportAttribute::class),
        ];
    }
}
