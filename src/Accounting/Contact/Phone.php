<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class Phone extends Model implements SerializesRequest
{
    private ?string $phoneType = null;

    private ?string $phoneNumber = null;

    private ?string $phoneAreaCode = null;

    private ?string $phoneCountryCode = null;

    public function getPhoneType(): ?string
    {
        return $this->phoneType;
    }

    public function setPhoneType(?string $phoneType): self
    {
        $this->phoneType = $phoneType;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPhoneAreaCode(): ?string
    {
        return $this->phoneAreaCode;
    }

    public function setPhoneAreaCode(?string $phoneAreaCode): self
    {
        $this->phoneAreaCode = $phoneAreaCode;

        return $this;
    }

    public function getPhoneCountryCode(): ?string
    {
        return $this->phoneCountryCode;
    }

    public function setPhoneCountryCode(?string $phoneCountryCode): self
    {
        $this->phoneCountryCode = $phoneCountryCode;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'PhoneType' => Field::string(),
            'PhoneNumber' => Field::string(),
            'PhoneAreaCode' => Field::string(),
            'PhoneCountryCode' => Field::string(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'PhoneType' => $this->getPhoneType(),
            'PhoneNumber' => $this->getPhoneNumber(),
            'PhoneAreaCode' => $this->getPhoneAreaCode(),
            'PhoneCountryCode' => $this->getPhoneCountryCode(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
