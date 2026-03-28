<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final class UserActivity
{
    public function __construct(
        private ?string $userId = null,
        private ?string $fullName = null,
        private ?int $transactionCount = null
    ) {
    }

    public function getUserId(): ?string { return $this->userId; }
    public function setUserId(?string $userId): self { $this->userId = $userId; return $this; }
    public function getFullName(): ?string { return $this->fullName; }
    public function setFullName(?string $fullName): self { $this->fullName = $fullName; return $this; }
    public function getTransactionCount(): ?int { return $this->transactionCount; }
    public function setTransactionCount(?int $transactionCount): self { $this->transactionCount = $transactionCount; return $this; }
}
