<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

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

    /**
     * @return ResourceCollection<TrackingCategory>
     */
    public function trackingCategories(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Settings/trackingCategories')
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $trackingCategory): TrackingCategory => $this->mapTrackingCategory($trackingCategory),
            $payload['TrackingCategories'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return ResourceCollection<Reimbursement>
     */
    public function reimbursements(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Reimbursements')
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $reimbursement): Reimbursement => $this->mapReimbursement($reimbursement),
            $payload['Reimbursements'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function reimbursement(string $reimbursementId): ?Reimbursement
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Reimbursements/' . $reimbursementId)
            ->send()
            ->json();

        $reimbursement = $payload['Reimbursements'][0] ?? $payload['Reimbursement'] ?? null;

        return is_array($reimbursement) ? $this->mapReimbursement($reimbursement) : null;
    }

    public function createReimbursement(): ReimbursementPayload
    {
        return new ReimbursementPayload($this->client);
    }

    public function statutoryLeaveSummary(string $employeeId): StatutoryLeaveSummary
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/StatutoryLeaves/Summary/' . $employeeId)
            ->send()
            ->json();

        /** @var array<string, mixed>|null $summary */
        $summary = $payload['StatutoryLeaveSummary'] ?? null;

        if (! is_array($summary)) {
            return new StatutoryLeaveSummary();
        }

        return $this->mapStatutoryLeaveSummary($summary);
    }

    /**
     * @param array<string, mixed> $trackingCategory
     */
    public function mapTrackingCategory(array $trackingCategory): TrackingCategory
    {
        return (new TrackingCategory())->fill($trackingCategory);
    }

    /**
     * @param array<string, mixed> $reimbursement
     */
    public function mapReimbursement(array $reimbursement): Reimbursement
    {
        return (new Reimbursement())->fill($reimbursement);
    }

    /**
     * @param array<string, mixed> $summary
     */
    public function mapStatutoryLeaveSummary(array $summary): StatutoryLeaveSummary
    {
        return (new StatutoryLeaveSummary())->fill($summary);
    }
}
