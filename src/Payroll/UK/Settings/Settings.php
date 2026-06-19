<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

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

    /**
     * @return array<string, mixed>
     */
    public function trackingCategories(): array
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Settings/trackingCategories')
            ->send()
            ->json();

        return Json::extractObject($payload, 'trackingCategories');
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

        $items = array_map(
            fn (array $reimbursement): Reimbursement => $this->mapReimbursement($reimbursement),
            Json::extractList($payload, 'reimbursements')
        );

        return new ResourceCollection($items);
    }

    public function reimbursement(string $reimbursementId): ?Reimbursement
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Reimbursements/' . $reimbursementId)
            ->send()
            ->json();

        $reimbursement = Json::extractFirst($payload, 'reimbursements') ?? Json::extractObject($payload, 'reimbursement') ?: null;

        return $reimbursement !== null ? $this->mapReimbursement($reimbursement) : null;
    }

    public function createReimbursement(): ReimbursementPayload
    {
        return new ReimbursementPayload($this->client);
    }

    /**
     * @return ResourceCollection<StatutoryLeaveSummary>
     */
    public function statutoryLeaveSummary(string $employeeId): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/StatutoryLeaves/Summary/' . $employeeId)
            ->send()
            ->json();

        $items = array_map(
            fn (array $summary): StatutoryLeaveSummary => $this->mapStatutoryLeaveSummary($summary),
            Json::extractList($payload, 'statutoryLeaves')
        );

        return new ResourceCollection($items);
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
