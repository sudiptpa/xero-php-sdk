<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Product extends Model
{
    /**
     */
    public function __construct(
        private ?string $superFundProductID = null,
        private ?string $name = null,
        private ?string $uSI = null,
        private ?string $aBN = null,
    ) {
    }

    public function getSuperFundProductID(): ?string
    {
        return $this->superFundProductID;
    }
    public function setSuperFundProductID(?string $superFundProductID): self
    {
        $this->superFundProductID = $superFundProductID;
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
    public function getUSI(): ?string
    {
        return $this->uSI;
    }
    public function setUSI(?string $uSI): self
    {
        $this->uSI = $uSI;
        return $this;
    }
    public function getABN(): ?string
    {
        return $this->aBN;
    }
    public function setABN(?string $aBN): self
    {
        $this->aBN = $aBN;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'SuperFundProductID' => Field::string()->using('setSuperFundProductID'),
            'Name' => Field::string()->using('setName'),
            'USI' => Field::string()->using('setUSI'),
            'ABN' => Field::string()->using('setABN'),
        ];
    }
}
