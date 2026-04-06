<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransaction;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class BankAccount extends Model implements SerializesRequest
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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'AccountID' => Field::string(),
        ];
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
