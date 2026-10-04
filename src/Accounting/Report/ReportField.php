<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ReportField extends Model
{
    private ?string $fieldID = null;

    private ?string $description = null;

    private ?string $value = null;

    public function getFieldID(): ?string
    {
        return $this->fieldID;
    }

    public function setFieldID(?string $fieldID): self
    {
        $this->fieldID = $fieldID;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            'FieldID' => Field::string(),
            'Description' => Field::string(),
            'Value' => Field::string(),
        ];
    }
}
