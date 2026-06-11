<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final readonly class FinancialStatements implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['finance.statements.read']
        );
    }

    public function balanceSheet(?DateTimeInterface $balanceDate = null): Statement
    {
        return $this->statement(
            '/finance.xro/1.0/FinancialStatements/BalanceSheet',
            'balance_sheet',
            $balanceDate === null ? [] : ['balanceDate' => $balanceDate->format('Y-m-d')]
        );
    }

    public function cashflow(?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null): Statement
    {
        return $this->statement('/finance.xro/1.0/FinancialStatements/Cashflow', 'cashflow', $this->dateRange($startDate, $endDate));
    }

    public function profitAndLoss(?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null): Statement
    {
        return $this->statement('/finance.xro/1.0/FinancialStatements/ProfitAndLoss', 'profit_and_loss', $this->dateRange($startDate, $endDate));
    }

    public function trialBalance(?DateTimeInterface $balanceDate = null): Statement
    {
        return $this->statement(
            '/finance.xro/1.0/FinancialStatements/TrialBalance',
            'trial_balance',
            $balanceDate === null ? [] : ['balanceDate' => $balanceDate->format('Y-m-d')]
        );
    }

    /**
     * @param list<string> $contactIds
     * @return ResourceCollection<ContactStatement>
     */
    public function contactExpenses(array $contactIds = [], ?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null): ResourceCollection
    {
        return $this->contactStatementCollection(
            '/finance.xro/1.0/FinancialStatements/contacts/expense',
            $contactIds,
            $startDate,
            $endDate
        );
    }

    /**
     * @param list<string> $contactIds
     * @return ResourceCollection<ContactStatement>
     */
    public function contactRevenue(array $contactIds = [], ?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null): ResourceCollection
    {
        return $this->contactStatementCollection(
            '/finance.xro/1.0/FinancialStatements/contacts/revenue',
            $contactIds,
            $startDate,
            $endDate
        );
    }

    /**
     * @param array<string, scalar|array<int, scalar>|null> $query
     */
    private function statement(string $path, string $type, array $query): Statement
    {
        $payload = $this->client
            ->get($path)
            ->withQuery($query)
            ->send()
            ->json();

        $statement = Json::extractObject($payload, 'FinancialStatement')
            ?: Json::extractObject($payload, 'Report')
            ?: $payload;

        if ($statement === []) {
            return new Statement($type);
        }

        return (new Statement())
            ->fill(['Type' => $type] + $statement);
    }

    /**
     * @param list<string> $contactIds
     * @return ResourceCollection<ContactStatement>
     */
    private function contactStatementCollection(
        string $path,
        array $contactIds,
        ?DateTimeInterface $startDate,
        ?DateTimeInterface $endDate
    ): ResourceCollection {
        $query = $this->dateRange($startDate, $endDate);

        if ($contactIds !== []) {
            $query['contactIds'] = $contactIds;
        }

        $payload = $this->client
            ->get($path)
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_map(
            fn (array $statement): ContactStatement => $this->mapContactStatement($statement),
            Json::extractList($payload, 'Items') ?: Json::extractList($payload, 'Contacts')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return array<string, string>
     */
    private function dateRange(?DateTimeInterface $startDate, ?DateTimeInterface $endDate): array
    {
        $query = [];

        if ($startDate !== null) {
            $query['startDate'] = $startDate->format('Y-m-d');
        }

        if ($endDate !== null) {
            $query['endDate'] = $endDate->format('Y-m-d');
        }

        return $query;
    }

    /**
     * @param array<string, mixed> $statement
     */
    private function mapContactStatement(array $statement): ContactStatement
    {
        return (new ContactStatement())->fill($statement);
    }
}
