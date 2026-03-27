<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Phone implements SerializesForRequest
{
    private ?string $phoneType = null;

    private ?string $phoneNumber = null;

    private ?string $phoneAreaCode = null;

    private ?string $phoneCountryCode = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload): self
    {
        return (new self())
            ->setPhoneType($payload['PhoneType'] ?? null)
            ->setPhoneNumber($payload['PhoneNumber'] ?? null)
            ->setPhoneAreaCode($payload['PhoneAreaCode'] ?? null)
            ->setPhoneCountryCode($payload['PhoneCountryCode'] ?? null);
    }

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
