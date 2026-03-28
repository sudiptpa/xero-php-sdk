<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
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

    public function get(): PayrollSettings
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Settings')
            ->send()
            ->json();

        /** @var array<string, mixed>|null $settings */
        $settings = $payload['Settings'] ?? null;

        if (! is_array($settings)) {
            return new PayrollSettings();
        }

        return $this->mapSettings($settings);
    }

    /**
     * @return ResourceCollection<StatutoryDeduction>
     */
    public function statutoryDeductions(?int $page = null): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/StatutoryDeductions')
            ->withQuery(array_filter([
                'page' => $page,
            ], static fn (mixed $value): bool => $value !== null))
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $deduction): StatutoryDeduction => $this->mapStatutoryDeduction($deduction),
            $payload['StatutoryDeductions'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function statutoryDeduction(string $id): ?StatutoryDeduction
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/StatutoryDeductions/' . $id)
            ->send()
            ->json();

        $deduction = $payload['StatutoryDeductions'][0] ?? $payload['StatutoryDeduction'] ?? null;

        return is_array($deduction) ? $this->mapStatutoryDeduction($deduction) : null;
    }

    /**
     * @param array<string, mixed> $settings
     */
    public function mapSettings(array $settings): PayrollSettings
    {
        return (new PayrollSettings())
            ->setAccounts(array_values($settings['Accounts'] ?? []))
            ->setTrackingCategories(array_values($settings['TrackingCategories'] ?? []))
            ;
    }

    /**
     * @param array<string, mixed> $deduction
     */
    public function mapStatutoryDeduction(array $deduction): StatutoryDeduction
    {
        return (new StatutoryDeduction())
            ->setStatutoryDeductionID($deduction['StatutoryDeductionID'] ?? null)
            ->setName($deduction['Name'] ?? null)
            ;
    }
}
