<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Address extends Model implements SerializesRequest
{
    private ?string $addressType = null;

    private ?string $addressLine1 = null;

    private ?string $addressLine2 = null;

    private ?string $addressLine3 = null;

    private ?string $addressLine4 = null;

    private ?string $city = null;

    private ?string $region = null;

    private ?string $postalCode = null;

    private ?string $country = null;

    private ?string $attentionTo = null;

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

    public function getAddressLine3(): ?string
    {
        return $this->addressLine3;
    }

    public function setAddressLine3(?string $addressLine3): self
    {
        $this->addressLine3 = $addressLine3;

        return $this;
    }

    public function getAddressLine4(): ?string
    {
        return $this->addressLine4;
    }

    public function setAddressLine4(?string $addressLine4): self
    {
        $this->addressLine4 = $addressLine4;

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

    public function getAttentionTo(): ?string
    {
        return $this->attentionTo;
    }

    public function setAttentionTo(?string $attentionTo): self
    {
        $this->attentionTo = $attentionTo;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'AddressType' => Field::string(),
            'AddressLine1' => Field::string(),
            'AddressLine2' => Field::string(),
            'AddressLine3' => Field::string(),
            'AddressLine4' => Field::string(),
            'City' => Field::string(),
            'Region' => Field::string(),
            'PostalCode' => Field::string(),
            'Country' => Field::string(),
            'AttentionTo' => Field::string(),
        ];
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
            'AddressLine3' => $this->getAddressLine3(),
            'AddressLine4' => $this->getAddressLine4(),
            'City' => $this->getCity(),
            'Region' => $this->getRegion(),
            'PostalCode' => $this->getPostalCode(),
            'Country' => $this->getCountry(),
            'AttentionTo' => $this->getAttentionTo(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
