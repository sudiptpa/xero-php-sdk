<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransaction;

use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class BankAccount implements SerializesForRequest
{
    private ?string $accountID = null;

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }

    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'AccountID' => $this->getAccountID(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
