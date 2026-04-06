<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Reports implements DefinesScopes
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['accounting.reports.read']
        );
    }

    /**
     * @return ResourceCollection<Report>
     */
    public function list(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Reports')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $report): Report => $this->mapReport($report),
            $payload['Reports'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $reportId): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/' . $reportId);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function profitAndLoss(array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/ProfitAndLoss', $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function balanceSheet(array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/BalanceSheet', $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function trialBalance(array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/TrialBalance', $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function bankSummary(array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/BankSummary', $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function budgetSummary(array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/BudgetSummary', $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function executiveSummary(array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/ExecutiveSummary', $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function agedReceivablesByContact(string $contactId, array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/AgedReceivablesByContact', ['contactId' => $contactId] + $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function agedPayablesByContact(string $contactId, array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/AgedPayablesByContact', ['contactId' => $contactId] + $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    public function tenNinetyNine(array $query = []): ?Report
    {
        return $this->fetch('/api.xro/2.0/Reports/TenNinetyNine', $query);
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     */
    private function fetch(string $path, array $query = []): ?Report
    {
        $response = $this->client
            ->get($path)
            ->withQuery($this->normalizeQuery($query))
            ->send();

        $payload = $response->json();
        $report = $payload['Reports'][0] ?? null;

        return is_array($report) ? $this->mapReport($report) : null;
    }

    /**
     * @param array<string, scalar|DateTimeInterface|null> $query
     * @return array<string, scalar>
     */
    private function normalizeQuery(array $query): array
    {
        $normalized = [];

        foreach ($query as $key => $value) {
            if ($value === null) {
                continue;
            }

            if ($value instanceof DateTimeInterface) {
                $normalized[$key] = $value->format('Y-m-d');
                continue;
            }

            if (is_bool($value)) {
                $normalized[$key] = $value ? 'true' : 'false';
                continue;
            }

            $normalized[$key] = $value;
        }

        return $normalized;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapReport(array $payload): Report
    {
        return (new Report())->fill($payload);
    }
}
