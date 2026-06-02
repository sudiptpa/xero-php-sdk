<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\InvoiceReminder;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class InvoiceReminderSettings extends Model
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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Enabled' => Field::boolean(),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        $rawDays = is_array($payload['Days'] ?? null) ? $payload['Days'] : [];
        $days = [];
        foreach ($rawDays as $day) {
            if (is_int($day) || is_string($day)) {
                $days[] = $day;
            }
        }

        return $this->setDays($days);
    }
}
