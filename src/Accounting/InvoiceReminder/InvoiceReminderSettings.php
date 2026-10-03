<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\InvoiceReminder;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class InvoiceReminderSettings extends Model
{
    private bool $enabled = false;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Enabled' => Field::boolean(),
        ];
    }
}
