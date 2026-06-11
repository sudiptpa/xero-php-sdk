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
            'FinancialStatement' => [
                'Rows' => [['Title' => 'Assets']],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'FinancialStatement' => [
                'Rows' => [['Title' => 'Cash flow']],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'FinancialStatement' => [
                'Rows' => [['Title' => 'Profit and Loss']],
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
        $revenue = $statements->contactRevenue(['contact-2'], new DateTimeImmutable('2026-03-01'), new DateTimeImmutable('2026-03-31'));

        self::assertSame('/finance.xro/1.0/FinancialStatements/BalanceSheet', $transport->requests()[0]->path);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['balanceDate']);
        self::assertSame('/finance.xro/1.0/FinancialStatements/Cashflow', $transport->requests()[1]->path);
        self::assertSame('/finance.xro/1.0/FinancialStatements/ProfitAndLoss', $transport->requests()[2]->path);
        self::assertSame('/finance.xro/1.0/FinancialStatements/TrialBalance', $transport->requests()[3]->path);
        self::assertSame('/finance.xro/1.0/FinancialStatements/contacts/expense', $transport->requests()[4]->path);
        self::assertSame(['contact-1'], $transport->requests()[4]->query['contactIds']);
        self::assertSame('/finance.xro/1.0/FinancialStatements/contacts/revenue', $transport->requests()[5]->path);
        self::assertSame(['contact-2'], $transport->requests()[5]->query['contactIds']);
        self::assertNotEmpty($balanceSheet->getRows());
        self::assertNotEmpty($cashflow->getRows());
        self::assertNotEmpty($profitAndLoss->getRows());
        self::assertNotEmpty($trialBalance->getRows());
        self::assertNotNull($expenses->first());
        self::assertNotNull($revenue->first());
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
