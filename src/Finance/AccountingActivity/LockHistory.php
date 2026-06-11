<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class LockHistory extends Model
{
    public function __construct(
        private ?string $lockDate = null,
        private ?string $lockType = null,
        private ?string $changedDateUTC = null
    ) {
    }

    public function getLockDate(): ?string
    {
        return $this->lockDate;
    }
    public function setLockDate(?string $lockDate): self
    {
        $this->lockDate = $lockDate;
        return $this;
    }
    public function getLockType(): ?string
    {
        return $this->lockType;
    }
    public function setLockType(?string $lockType): self
    {
        $this->lockType = $lockType;
        return $this;
    }
    public function getChangedDateUTC(): ?string
    {
        return $this->changedDateUTC;
    }
    public function setChangedDateUTC(?string $changedDateUTC): self
    {
        $this->changedDateUTC = $changedDateUTC;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'LockDate' => Field::string()->using('setLockDate'),
            'LockType' => Field::string()->using('setLockType'),
            'ChangedDateUTC' => Field::string()->using('setChangedDateUTC'),
        ];
    }
}
