<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance;

final class BankStatementEntry
{
    public function __construct(
        private ?string $accountID = null,
        private ?string $accountName = null,
        private ?float $statementBalance = null
    ) {
    }

    public function getAccountID(): ?string { return $this->accountID; }
    public function setAccountID(?string $accountID): self { $this->accountID = $accountID; return $this; }
    public function getAccountName(): ?string { return $this->accountName; }
    public function setAccountName(?string $accountName): self { $this->accountName = $accountName; return $this; }
    public function getStatementBalance(): ?float { return $this->statementBalance; }
    public function setStatementBalance(?float $statementBalance): self { $this->statementBalance = $statementBalance; return $this; }
}
