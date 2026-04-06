<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class AccountingActivities implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['finance.accountingactivity.read']
        );
    }

    /**
     * @return ResourceCollection<AccountingActivity>
     */
    public function get(?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null): ResourceCollection
    {
        $query = [];

        if ($startDate !== null) {
            $query['startDate'] = $startDate->format('Y-m-d');
        }

        if ($endDate !== null) {
            $query['endDate'] = $endDate->format('Y-m-d');
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/AccountingActivities')
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $activity): AccountingActivity => $this->mapAccountingActivity($activity),
            $payload['Items'] ?? $payload['AccountingActivities'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return ResourceCollection<AccountUsage>
     */
    public function accountUsage(?string $startMonth = null, ?string $endMonth = null): ResourceCollection
    {
        $query = [];

        if ($startMonth !== null) {
            $query['startMonth'] = $startMonth;
        }

        if ($endMonth !== null) {
            $query['endMonth'] = $endMonth;
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/AccountingActivities/AccountUsage')
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $usage): AccountUsage => $this->mapAccountUsage($usage),
            $payload['Items'] ?? $payload['AccountUsage'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return ResourceCollection<ReportHistory>
     */
    public function reportHistory(?DateTimeInterface $endDate = null): ResourceCollection
    {
        $query = [];

        if ($endDate !== null) {
            $query['endDate'] = $endDate->format('Y-m-d');
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/AccountingActivities/ReportHistory')
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $history): ReportHistory => $this->mapReportHistory($history),
            $payload['Items'] ?? $payload['ReportHistory'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return ResourceCollection<LockHistory>
     */
    public function lockHistory(?DateTimeInterface $endDate = null): ResourceCollection
    {
        $query = [];

        if ($endDate !== null) {
            $query['endDate'] = $endDate->format('Y-m-d');
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/AccountingActivities/LockHistory')
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $history): LockHistory => $this->mapLockHistory($history),
            $payload['Items'] ?? $payload['LockHistory'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return ResourceCollection<UserActivity>
     */
    public function userActivities(?string $dataMonth = null): ResourceCollection
    {
        $query = [];

        if ($dataMonth !== null) {
            $query['dataMonth'] = $dataMonth;
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/AccountingActivities/UserActivities')
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $activity): UserActivity => $this->mapUserActivity($activity),
            $payload['Items'] ?? $payload['UserActivities'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @param array<string, mixed> $activity
     */
    public function mapAccountingActivity(array $activity): AccountingActivity
    {
        return (new AccountingActivity())->fill($activity);
    }

    /**
     * @param array<string, mixed> $usage
     */
    public function mapAccountUsage(array $usage): AccountUsage
    {
        return (new AccountUsage())->fill($usage);
    }

    /**
     * @param array<string, mixed> $history
     */
    public function mapReportHistory(array $history): ReportHistory
    {
        return (new ReportHistory())->fill($history);
    }

    /**
     * @param array<string, mixed> $history
     */
    public function mapLockHistory(array $history): LockHistory
    {
        return (new LockHistory())->fill($history);
    }

    /**
     * @param array<string, mixed> $activity
     */
    public function mapUserActivity(array $activity): UserActivity
    {
        return (new UserActivity())->fill($activity);
    }
}
