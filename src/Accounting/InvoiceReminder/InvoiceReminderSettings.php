<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\InvoiceReminder;

final readonly class InvoiceReminderSettings
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public bool $enabled,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['Enabled']) ? (bool) $payload['Enabled'] : false,
            $payload
        );
    }
}
