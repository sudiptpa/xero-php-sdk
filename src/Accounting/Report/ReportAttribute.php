<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ReportAttribute extends Model
{
    private ?string $id = null;

    private ?string $value = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Id' => Field::string(),
            'Value' => Field::string(),
        ];
    }
}
