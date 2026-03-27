<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class JournalLine implements BuildsFromPayload, SerializesForRequest
{
    private int|float|null $lineAmount = null;

    private ?string $accountCode = null;

    private ?bool $isDebit = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?\Sujip\Xero\Client $client = null): static
    {
        return (new self())
            ->setLineAmount($payload['LineAmount'] ?? null)
            ->setAccountCode($payload['AccountCode'] ?? null)
            ->setIsDebit($payload['IsDebit'] ?? null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?\Sujip\Xero\Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

    public function getLineAmount(): int|float|null
    {
        return $this->lineAmount;
    }

    public function setLineAmount(int|float|null $lineAmount): self
    {
        $this->lineAmount = $lineAmount;

        return $this;
    }

    public function getAccountCode(): ?string
    {
        return $this->accountCode;
    }

    public function setAccountCode(?string $accountCode): self
    {
        $this->accountCode = $accountCode;

        return $this;
    }

    public function getIsDebit(): ?bool
    {
        return $this->isDebit;
    }

    public function setIsDebit(?bool $isDebit): self
    {
        $this->isDebit = $isDebit;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'LineAmount' => $this->getLineAmount(),
            'AccountCode' => $this->getAccountCode(),
            'IsDebit' => $this->getIsDebit(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
