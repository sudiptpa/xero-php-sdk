<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final class LockHistory
{
    public function __construct(
        private ?string $lockDate = null,
        private ?string $lockType = null,
        private ?string $changedDateUTC = null
    ) {
    }

    public function getLockDate(): ?string { return $this->lockDate; }
    public function setLockDate(?string $lockDate): self { $this->lockDate = $lockDate; return $this; }
    public function getLockType(): ?string { return $this->lockType; }
    public function setLockType(?string $lockType): self { $this->lockType = $lockType; return $this; }
    public function getChangedDateUTC(): ?string { return $this->changedDateUTC; }
    public function setChangedDateUTC(?string $changedDateUTC): self { $this->changedDateUTC = $changedDateUTC; return $this; }
}
