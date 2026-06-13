<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class FinancialStatementsTest extends TestCase
{
    public function test_it_can_get_financial_statements_and_contact_views(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'balanceDate' => '2021-05-12',
            'asset' => [
                'accountTypes' => [
                    [
                        'accountType' => 'BANK',
                        'accounts' => [[
                            'accountID' => 'abcdeabc-3a6d-4c53-ba82-ea1c92d02ef4',
                            'name' => 'Buz Acc',
                            'reportingCode' => 'ASS',
                            'total' => -42.3,
                        ]],
                        'total' => -42.3,
                    ],
                ],
                'total' => -42.3,
            ],
            'liability' => [
                'accountTypes' => [
                    [
                        'accountType' => 'CURRLIAB',
                        'accounts' => [[
                            'code' => '800',
                            'accountID' => 'abcdeabc-80ba-4b58-8d72-f8e9ca0f2f00',
                            'name' => 'Accounts Payable',
                            'reportingCode' => 'LIA.CUR.PAY.TRA',
                            'total' => 44.4,
                        ]],
                        'total' => 44.4,
                    ],
                ],
                'total' => 44.4,
            ],
            'equity' => [
                'accountTypes' => [
                    [
                        'accountType' => 'EQUITY',
                        'accounts' => [[
                            'accountID' => '00000000-0000-0000-0000-000000000000',
                            'name' => 'Current Year Earnings',
                            'total' => 14.81,
                        ]],
                        'total' => 14.81,
                    ],
                ],
                'total' => 14.81,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'startDate' => '2018-07-01',
            'endDate' => '2019-06-30',
            'cashBalance' => [
                'openingCashBalance' => 5000,
                'closingCashBalance' => -50000,
                'netCashMovement' => -55000,
            ],
            'cashflowActivities' => [
                [
                    'name' => 'Operating Activities',
                    'total' => -41000,
                    'cashflowTypes' => [
                        [
                            'name' => 'Receipts from customers',
                            'total' => 34000,
                            'accounts' => [[
                                'accountId' => 'abcdefab-4d1e-4d1a-9e4c-68b2c2a278e2',
                                'accountType' => 'REVENUE',
                                'accountClass' => 'REVENUE',
                                'code' => '455',
                                'name' => 'Cellar Door - Till Variance',
                                'reportingCode' => 'EXP',
                                'total' => -1000,
                            ]],
                        ],
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'startDate' => '2020-07-01',
            'endDate' => '2021-06-30',
            'netProfitLoss' => 123,
            'revenue' => [
                'total' => 20922.46,
                'accountTypes' => [
                    [
                        'total' => 20825.41,
                        'title' => 'Trading Income',
                        'accounts' => [[
                            'accountID' => 'abcdefab-2006-43c2-a5da-3c0e5f43b452',
                            'accountType' => 'REVENUE',
                            'code' => '200',
                            'name' => 'Sales',
                            'reportingCode' => 'REV',
                            'total' => 20825.41,
                        ]],
                    ],
                ],
            ],
            'expense' => [
                'total' => 1234.56,
                'accountTypes' => [
                    [
                        'total' => 1234.56,
                        'title' => 'Operating Expenses',
                        'accounts' => [[
                            'accountID' => 'abcdefab-1111-43c2-a5da-3c0e5f43b452',
                            'accountType' => 'EXPENSE',
                            'code' => '400',
                            'name' => 'Advertising',
                            'reportingCode' => 'EXP',
                            'total' => 1234.56,
                        ]],
                    ],
                ],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'FinancialStatement' => [
                'Rows' => [['Title' => 'Trial Balance']],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'ContactID' => 'contact-1',
                'Name' => 'Acme',
                'Total' => 120,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'ContactID' => 'contact-2',
                'Name' => 'Globex',
                'Total' => 450,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');
        $statements = $client->finance()->statements();

        $balanceSheet = $statements->balanceSheet(new DateTimeImmutable('2026-03-31'));
        $cashflow = $statements->cashflow(new DateTimeImmutable('2026-03-01'), new DateTimeImmutable('2026-03-31'));
        $profitAndLoss = $statements->profitAndLoss(new DateTimeImmutable('2026-03-01'), new DateTimeImmutable('2026-03-31'));
        $trialBalance = $statements->trialBalance(new DateTimeImmutable('2026-03-31'));
        $expenses = $statements->contactExpenses(['contact-1'], new DateTimeImmutable('2026-03-01'), new DateTimeImmutable('2026-03-31'));
        $contactRevenue = $statements->contactRevenue(['contact-2'], new DateTimeImmutable('2026-03-01'), new DateTimeImmutable('2026-03-31'));

        self::assertSame('/finance.xro/1.0/FinancialStatements/BalanceSheet', $transport->requests()[0]->path);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['balanceDate']);
        self::assertSame('/finance.xro/1.0/FinancialStatements/Cashflow', $transport->requests()[1]->path);
        self::assertSame('/finance.xro/1.0/FinancialStatements/ProfitAndLoss', $transport->requests()[2]->path);
        self::assertSame('/finance.xro/1.0/FinancialStatements/TrialBalance', $transport->requests()[3]->path);
        self::assertSame('/finance.xro/1.0/FinancialStatements/contacts/expense', $transport->requests()[4]->path);
        self::assertSame(['contact-1'], $transport->requests()[4]->query['contactIds']);
        self::assertSame('/finance.xro/1.0/FinancialStatements/contacts/revenue', $transport->requests()[5]->path);
        self::assertSame(['contact-2'], $transport->requests()[5]->query['contactIds']);
        self::assertSame('2021-05-12', $balanceSheet->getBalanceDate());
        $asset = $balanceSheet->getAsset();
        self::assertNotNull($asset);
        self::assertSame(-42.3, $asset->getTotal());
        $bankType = $asset->getAccountTypes()[0];
        self::assertSame('BANK', $bankType->getAccountType());
        self::assertSame('Buz Acc', $bankType->getAccounts()[0]->getName());
        self::assertSame('ASS', $bankType->getAccounts()[0]->getReportingCode());

        $liability = $balanceSheet->getLiability();
        self::assertNotNull($liability);
        self::assertSame(44.4, $liability->getTotal());
        self::assertSame('800', $liability->getAccountTypes()[0]->getAccounts()[0]->getCode());

        $equity = $balanceSheet->getEquity();
        self::assertNotNull($equity);
        self::assertSame(14.81, $equity->getTotal());
        self::assertSame('Current Year Earnings', $equity->getAccountTypes()[0]->getAccounts()[0]->getName());

        self::assertSame('2018-07-01', $cashflow->getStartDate());
        self::assertSame('2019-06-30', $cashflow->getEndDate());
        $cashBalance = $cashflow->getCashBalance();
        self::assertNotNull($cashBalance);
        self::assertSame(-55000, $cashBalance->getNetCashMovement());
        $activity = $cashflow->getCashflowActivities()[0];
        self::assertSame('Operating Activities', $activity->getName());
        $type = $activity->getCashflowTypes()[0];
        self::assertSame('Receipts from customers', $type->getName());
        self::assertSame('Cellar Door - Till Variance', $type->getAccounts()[0]->getName());
        self::assertSame('REVENUE', $type->getAccounts()[0]->getAccountClass());
        self::assertSame('2020-07-01', $profitAndLoss->getStartDate());
        self::assertSame('2021-06-30', $profitAndLoss->getEndDate());
        self::assertSame(123, $profitAndLoss->getNetProfitLoss());
        $revenue = $profitAndLoss->getRevenue();
        self::assertNotNull($revenue);
        self::assertSame(20922.46, $revenue->getTotal());
        $tradingIncome = $revenue->getAccountTypes()[0];
        self::assertSame('Trading Income', $tradingIncome->getTitle());
        self::assertSame('Sales', $tradingIncome->getAccounts()[0]->getName());
        self::assertSame('REV', $tradingIncome->getAccounts()[0]->getReportingCode());
        $expense = $profitAndLoss->getExpense();
        self::assertNotNull($expense);
        self::assertSame('Advertising', $expense->getAccountTypes()[0]->getAccounts()[0]->getName());
        self::assertNotEmpty($trialBalance->getRows());
        self::assertNotNull($expenses->first());
        self::assertNotNull($contactRevenue->first());
    }

    public function test_it_can_get_finance_account_usage_and_report_history(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'AccountID' => 'account-1',
                'AccountCode' => '200',
                'AccountName' => 'Sales',
                'Amount' => 1200.5,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'ReportName' => 'Profit and Loss',
                'PublishedDateUTC' => '2026-03-31T00:00:00Z',
                'PublishedBy' => 'Jane',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $activities = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->finance()
            ->accountingActivities();

        $accountUsage = $activities->accountUsage('2025-04', '2026-03');
        $reportHistory = $activities->reportHistory(new DateTimeImmutable('2026-03-31'));

        self::assertSame('/finance.xro/1.0/AccountingActivities/AccountUsage', $transport->requests()[0]->path);
        self::assertSame('2025-04', $transport->requests()[0]->query['startMonth']);
        self::assertSame('2026-03', $transport->requests()[0]->query['endMonth']);
        self::assertSame('/finance.xro/1.0/AccountingActivities/ReportHistory', $transport->requests()[1]->path);
        self::assertSame('2026-03-31', $transport->requests()[1]->query['endDate']);
        self::assertNotNull($accountUsage->first());
        self::assertNotNull($reportHistory->first());
    }
}
