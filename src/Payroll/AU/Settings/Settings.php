<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Settings;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class Settings implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.settings'],
            granular: ['payroll.settings.read', 'payroll.settings']
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function get(): array
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/Settings')
            ->send();

        return $response->json();
    }
}
