<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class AccountUsage extends Model
{
    public function __construct(
        private ?string $accountID = null,
        private ?string $accountCode = null,
        private ?string $accountName = null,
        private ?float $amount = null
    ) {
    }

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }
    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;
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
    public function getAccountName(): ?string
    {
        return $this->accountName;
    }
    public function setAccountName(?string $accountName): self
    {
        $this->accountName = $accountName;
        return $this;
    }
    public function getAmount(): ?float
    {
        return $this->amount;
    }
    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'AccountID' => Field::string()->using('setAccountID'),
            'AccountCode' => Field::string()->using('setAccountCode'),
            'AccountName' => Field::string()->using('setAccountName'),
            'Amount' => Field::number()->using('setAmount'),
        ];
    }
}
