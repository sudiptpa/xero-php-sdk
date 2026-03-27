<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

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
    public function trackingCategories(): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Settings/trackingCategories')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function reimbursements(): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Reimbursements')
            ->send()
            ->json();
    }

    /**
     * @return array<string, mixed>
     */
    public function reimbursement(string $reimbursementId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/Reimbursements/' . $reimbursementId)
            ->send()
            ->json();
    }

    public function createReimbursement(): ReimbursementPayload
    {
        return new ReimbursementPayload($this->client);
    }

    /**
     * @return array<string, mixed>
     */
    public function statutoryLeaveSummary(string $employeeId): array
    {
        return $this->client
            ->get('/payroll.xro/2.0/StatutoryLeaves/Summary/' . $employeeId)
            ->send()
            ->json();
    }
}
