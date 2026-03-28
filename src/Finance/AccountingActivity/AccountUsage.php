<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final class AccountUsage
{
    public function __construct(
        private ?string $accountID = null,
        private ?string $accountCode = null,
        private ?string $accountName = null,
        private ?float $amount = null
    ) {
    }

    public function getAccountID(): ?string { return $this->accountID; }
    public function setAccountID(?string $accountID): self { $this->accountID = $accountID; return $this; }
    public function getAccountCode(): ?string { return $this->accountCode; }
    public function setAccountCode(?string $accountCode): self { $this->accountCode = $accountCode; return $this; }
    public function getAccountName(): ?string { return $this->accountName; }
    public function setAccountName(?string $accountName): self { $this->accountName = $accountName; return $this; }
    public function getAmount(): ?float { return $this->amount; }
    public function setAmount(?float $amount): self { $this->amount = $amount; return $this; }
}
