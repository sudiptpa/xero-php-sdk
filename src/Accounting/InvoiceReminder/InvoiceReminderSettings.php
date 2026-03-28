<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\InvoiceReminder;

final class InvoiceReminderSettings
{
    private bool $enabled = false;

    /**
     * @var list<int|string>
     */
    private array $days = [];

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return list<int|string>
     */
    public function getDays(): array
    {
        return $this->days;
    }

    /**
     * @param list<int|string> $days
     */
    public function setDays(array $days): self
    {
        $this->days = $days;

        return $this;
    }
}
