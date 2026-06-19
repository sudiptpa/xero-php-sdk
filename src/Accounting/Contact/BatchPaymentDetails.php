<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class BatchPaymentDetails extends Model implements SerializesRequest
{
    private ?string $bankAccountNumber = null;

    private ?string $bankAccountName = null;

    private ?string $details = null;

    private ?string $code = null;

    private ?string $reference = null;

    public function getBankAccountNumber(): ?string
    {
        return $this->bankAccountNumber;
    }

    public function setBankAccountNumber(?string $bankAccountNumber): self
    {
        $this->bankAccountNumber = $bankAccountNumber;

        return $this;
    }

    public function getBankAccountName(): ?string
    {
        return $this->bankAccountName;
    }

    public function setBankAccountName(?string $bankAccountName): self
    {
        $this->bankAccountName = $bankAccountName;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'BankAccountNumber' => Field::string(),
            'BankAccountName' => Field::string(),
            'Details' => Field::string(),
            'Code' => Field::string(),
            'Reference' => Field::string(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'BankAccountNumber' => $this->getBankAccountNumber(),
            'BankAccountName' => $this->getBankAccountName(),
            'Details' => $this->getDetails(),
            'Code' => $this->getCode(),
            'Reference' => $this->getReference(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
