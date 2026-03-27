<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\InvoiceReminder;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class InvoiceReminders implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.settings'],
            granular: ['accounting.settings.read', 'accounting.settings']
        );
    }

    public function settings(): InvoiceReminderSettings
    {
        $payload = $this->client
            ->get('/api.xro/2.0/InvoiceReminders/Settings')
            ->send()
            ->json();

        $settings = $payload['InvoiceReminders'] ?? $payload['InvoiceReminderSettings'] ?? $payload;

        return InvoiceReminderSettings::fromArray(is_array($settings) ? $settings : []);
    }
}
