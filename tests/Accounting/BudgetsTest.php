<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Budget\Budget;
use Sujip\Xero\Accounting\Budget\BudgetBalance;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class BudgetsTest extends TestCase
{
    public function test_it_can_query_and_find_budgets(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Budgets' => [[
                'BudgetID' => 'budget-1',
                'Status' => 'APPROVED',
                'Description' => 'FY2021 budget',
                'Type' => 'TRACKING',
                'UpdatedDateUTC' => '/Date(1622138002077+0000)/',
                'BudgetLines' => [],
                'Tracking' => [],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Budgets' => [[
                'BudgetID' => 'budget-1',
                'Type' => 'TRACKING',
                'Description' => 'Daniels Northern Budget',
                'UpdatedDateUTC' => '/Date(1622138002077+0000)/',
                'Tracking' => [[
                    'TrackingCategoryID' => 'category-1',
                    'Name' => 'Region',
                    'Options' => [],
                ]],
                'BudgetLines' => [[
                    'AccountID' => 'account-1',
                    'AccountCode' => '200',
                    'BudgetBalances' => [[
                        'Period' => '2019-08',
                        'Amount' => 1000,
                        'Notes' => 'Sample note',
                    ]],
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $budgets = $client->accounting()->budgets()
            ->dateFrom('2019-08-01')
            ->dateTo('2019-10-31')
            ->ids('budget-1')
            ->get();

        $budget = $client->accounting()->budgets()->find('budget-1');

        self::assertSame('/api.xro/2.0/Budgets', $transport->requests()[0]->path);
        self::assertSame('2019-08-01', $transport->requests()[0]->query['DateFrom']);
        self::assertSame('2019-10-31', $transport->requests()[0]->query['DateTo']);
        self::assertSame('budget-1', $transport->requests()[0]->query['IDs']);
        $firstBudget = $budgets->first();
        self::assertInstanceOf(Budget::class, $firstBudget);
        self::assertSame('budget-1', $firstBudget->getBudgetID());

        self::assertSame('/api.xro/2.0/Budgets/budget-1', $transport->requests()[1]->path);
        self::assertInstanceOf(Budget::class, $budget);
        self::assertSame('TRACKING', $budget->getType());
        self::assertSame('APPROVED', $firstBudget->getStatus());
        self::assertSame('Daniels Northern Budget', $budget->getDescription());
        self::assertSame('/Date(1622138002077+0000)/', $budget->getUpdatedDateUTC());

        $line = $budget->getBudgetLines()[0];
        self::assertSame('account-1', $line->getAccountID());
        self::assertSame('200', $line->getAccountCode());

        $balance = $line->getBudgetBalances()[0];
        self::assertSame('2019-08', $balance->getPeriod());
        self::assertSame(1000.0, $balance->getAmount());
        self::assertSame('Sample note', $balance->getNotes());

        $tracking = $budget->getTracking()[0];
        self::assertSame('category-1', $tracking->getTrackingCategoryID());
        self::assertSame('Region', $tracking->getName());
    }

    public function test_it_returns_null_when_budget_not_found(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        self::assertNull($client->accounting()->budgets()->find('missing'));
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->budgets()
            ->scopes();

        self::assertSame([], $scopes->broad);
        self::assertSame(['accounting.budgets.read'], $scopes->granular);
    }

    public function test_budget_balance_exposes_unit_amount(): void
    {
        $balance = (new BudgetBalance())->fill([
            'Period' => '2019-08',
            'Amount' => 1000,
            'UnitAmount' => 12.5,
            'Notes' => 'Sample note',
        ]);

        self::assertSame(12.5, $balance->getUnitAmount());
    }
}
