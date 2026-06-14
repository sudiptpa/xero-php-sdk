<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LineItemItem extends Model
{
    private ?string $code = null;

    private ?string $name = null;

    private ?string $itemID = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getItemID(): ?string
    {
        return $this->itemID;
    }

    public function setItemID(?string $itemID): self
    {
        $this->itemID = $itemID;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Code' => Field::string(),
            'Name' => Field::string(),
            'ItemID' => Field::string(),
        ];
    }
}
