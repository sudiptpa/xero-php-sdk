<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ScopeRequirements;

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

    public function balanceSheet(?DateTimeInterface $balanceDate = null): BalanceSheet
    {
        $payload = $this->client
            ->get('/finance.xro/1.0/FinancialStatements/BalanceSheet')
            ->withQuery($balanceDate === null ? [] : ['balanceDate' => $balanceDate->format('Y-m-d')])
            ->send()
            ->json();

        return (new BalanceSheet())->fill($payload);
    }

    public function cashflow(?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null): Cashflow
    {
        $payload = $this->client
            ->get('/finance.xro/1.0/FinancialStatements/Cashflow')
            ->withQuery($this->dateRange($startDate, $endDate))
            ->send()
            ->json();

        return (new Cashflow())->fill($payload);
    }

    public function profitAndLoss(?DateTimeInterface $startDate = null, ?DateTimeInterface $endDate = null): ProfitAndLoss
    {
        $payload = $this->client
            ->get('/finance.xro/1.0/FinancialStatements/ProfitAndLoss')
            ->withQuery($this->dateRange($startDate, $endDate))
            ->send()
            ->json();

        return (new ProfitAndLoss())->fill($payload);
    }

    public function trialBalance(?DateTimeInterface $endDate = null): TrialBalance
    {
        $payload = $this->client
            ->get('/finance.xro/1.0/FinancialStatements/TrialBalance')
            ->withQuery($endDate === null ? [] : ['endDate' => $endDate->format('Y-m-d')])
            ->send()
            ->json();

        return (new TrialBalance())->fill($payload);
    }

    /**
     * @param list<string> $contactIds
     */
    public function contactExpenses(
        array $contactIds = [],
        ?DateTimeInterface $startDate = null,
        ?DateTimeInterface $endDate = null,
        ?bool $includeManualJournals = null
    ): IncomeByContact {
        return $this->incomeByContact(
            '/finance.xro/1.0/FinancialStatements/contacts/expense',
            $contactIds,
            $startDate,
            $endDate,
            $includeManualJournals
        );
    }

    /**
     * @param list<string> $contactIds
     */
    public function contactRevenue(
        array $contactIds = [],
        ?DateTimeInterface $startDate = null,
        ?DateTimeInterface $endDate = null,
        ?bool $includeManualJournals = null
    ): IncomeByContact {
        return $this->incomeByContact(
            '/finance.xro/1.0/FinancialStatements/contacts/revenue',
            $contactIds,
            $startDate,
            $endDate,
            $includeManualJournals
        );
    }

    /**
     * @param list<string> $contactIds
     */
    private function incomeByContact(
        string $path,
        array $contactIds,
        ?DateTimeInterface $startDate,
        ?DateTimeInterface $endDate,
        ?bool $includeManualJournals
    ): IncomeByContact {
        $query = $this->dateRange($startDate, $endDate);

        if ($contactIds !== []) {
            $query['contactIds'] = $contactIds;
        }

        if ($includeManualJournals !== null) {
            $query['includeManualJournals'] = $includeManualJournals ? 'true' : 'false';
        }

        $payload = $this->client
            ->get($path)
            ->withQuery($query)
            ->send()
            ->json();

        return (new IncomeByContact())->fill($payload);
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
}
