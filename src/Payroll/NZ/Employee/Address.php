<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Address extends Model
{
    public function __construct(
        private ?string $addressLine1 = null,
        private ?string $addressLine2 = null,
        private ?string $city = null,
        private ?string $suburb = null,
        private ?string $postCode = null,
        private ?string $countryName = null,
    ) {
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function setAddressLine1(?string $addressLine1): self
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function setAddressLine2(?string $addressLine2): self
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getSuburb(): ?string
    {
        return $this->suburb;
    }

    public function setSuburb(?string $suburb): self
    {
        $this->suburb = $suburb;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(?string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'addressLine1' => Field::string()->using('setAddressLine1'),
            'addressLine2' => Field::string()->using('setAddressLine2'),
            'city' => Field::string()->using('setCity'),
            'suburb' => Field::string()->using('setSuburb'),
            'postCode' => Field::string()->using('setPostCode'),
            'countryName' => Field::string()->using('setCountryName'),
        ];
    }
}
