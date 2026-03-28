<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class JournalLine implements SerializesForRequest
{
    private int|float|null $lineAmount = null;

    private ?string $accountCode = null;

    private ?bool $isDebit = null;

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
