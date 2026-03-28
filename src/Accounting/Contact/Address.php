<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Address implements SerializesForRequest
{
    private ?string $addressType = null;

    private ?string $addressLine1 = null;

    private ?string $addressLine2 = null;

    private ?string $city = null;

    private ?string $region = null;

    private ?string $postalCode = null;

    private ?string $country = null;

    public function getAddressType(): ?string
    {
        return $this->addressType;
    }

    public function setAddressType(?string $addressType): self
    {
        $this->addressType = $addressType;

        return $this;
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

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'AddressType' => $this->getAddressType(),
            'AddressLine1' => $this->getAddressLine1(),
            'AddressLine2' => $this->getAddressLine2(),
            'City' => $this->getCity(),
            'Region' => $this->getRegion(),
            'PostalCode' => $this->getPostalCode(),
            'Country' => $this->getCountry(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
