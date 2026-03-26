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
            static fn (array $activity): AccountingActivity => AccountingActivity::fromArray($activity),
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
            static fn (array $usage): AccountUsage => AccountUsage::fromArray($usage),
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
            static fn (array $history): ReportHistory => ReportHistory::fromArray($history),
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
            static fn (array $history): LockHistory => LockHistory::fromArray($history),
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
            static fn (array $activity): UserActivity => UserActivity::fromArray($activity),
            $payload['Items'] ?? $payload['UserActivities'] ?? []
        ));

        return new ResourceCollection($items);
    }
}
