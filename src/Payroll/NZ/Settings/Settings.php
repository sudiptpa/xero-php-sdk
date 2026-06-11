<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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
        $settings = $payload['settings'] ?? null;

        if (! is_array($settings)) {
            return new PayrollSettings();
        }

        return $this->mapSettings($settings);
    }

    /**
     * @return array<string, mixed>
     */
    public function trackingCategories(): array
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Settings/TrackingCategories')
            ->send()
            ->json();

        return Json::extractObject($payload, 'trackingCategories');
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

        $items = array_map(
            fn (array $deduction): StatutoryDeduction => $this->mapStatutoryDeduction($deduction),
            Json::extractList($payload, 'statutoryDeductions')
        );

        return new ResourceCollection($items);
    }

    public function statutoryDeduction(string $id): ?StatutoryDeduction
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/StatutoryDeductions/' . $id)
            ->send()
            ->json();

        $deduction = Json::extractFirst($payload, 'statutoryDeductions') ?? Json::extractObject($payload, 'statutoryDeduction') ?: null;

        return $deduction !== null ? $this->mapStatutoryDeduction($deduction) : null;
    }

    /**
     * @param array<string, mixed> $settings
     */
    public function mapSettings(array $settings): PayrollSettings
    {
        return (new PayrollSettings())->fill($settings);
    }

    /**
     * @param array<string, mixed> $deduction
     */
    public function mapStatutoryDeduction(array $deduction): StatutoryDeduction
    {
        return (new StatutoryDeduction())->fill($deduction);
    }
}
