<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Product extends Model
{
    public function __construct(
        private ?string $abn = null,
        private ?string $usi = null,
        private ?string $spin = null,
        private ?string $productName = null,
    ) {
    }

    public function getAbn(): ?string
    {
        return $this->abn;
    }

    public function setAbn(?string $abn): self
    {
        $this->abn = $abn;

        return $this;
    }

    public function getUsi(): ?string
    {
        return $this->usi;
    }

    public function setUsi(?string $usi): self
    {
        $this->usi = $usi;

        return $this;
    }

    public function getSpin(): ?string
    {
        return $this->spin;
    }

    public function setSpin(?string $spin): self
    {
        $this->spin = $spin;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ABN' => Field::string()->using('setAbn'),
            'USI' => Field::string()->using('setUsi'),
            'SPIN' => Field::string()->using('setSpin'),
            'ProductName' => Field::string()->using('setProductName'),
        ];
    }
}
