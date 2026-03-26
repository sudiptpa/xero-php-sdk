<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

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
        return $this->client
            ->get('/payroll.xro/2.0/Settings')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function statutoryDeductions(?int $page = null): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/StatutoryDeductions')
            ->withQuery(array_filter([
                'page' => $page,
            ], static fn (mixed $value): bool => $value !== null))
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function statutoryDeduction(string $id): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/StatutoryDeductions/' . $id)
            ->send()
            ->json();
    }
}
