<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Journal\Journal;
use Sujip\Xero\Accounting\Report\Report;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class JournalsAndReportsTest extends TestCase
{
    public function test_it_can_query_and_find_journals(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Journals' => [[
                'JournalID' => 'journal-1',
                'JournalNumber' => 1250,
                'SourceType' => 'ACCPAY',
                'SourceID' => 'source-1',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Journals' => [[
                'JournalID' => 'journal-1',
                'JournalDate' => '2026-03-25T00:00:00',
                'JournalNumber' => 1250,
                'CreatedDateUTC' => '2026-03-25T01:00:00',
                'Reference' => 'INV-001',
                'SourceType' => 'ACCPAY',
                'SourceID' => 'source-1',
                'JournalLines' => [[
                    'JournalLineID' => 'line-1',
                    'AccountID' => 'account-1',
                    'AccountCode' => '200',
                    'AccountType' => 'REVENUE',
                    'AccountName' => 'Sales',
                    'Description' => 'Sale of goods',
                    'NetAmount' => 100.0,
                    'GrossAmount' => 115.0,
                    'TaxAmount' => 15.0,
                    'TaxType' => 'OUTPUT2',
                    'TaxName' => 'GST on Income',
                    'TrackingCategories' => [[
                        'TrackingCategoryID' => 'category-1',
                        'Name' => 'Region',
                    ]],
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Journals' => [[
                'JournalID' => 'journal-2',
                'JournalNumber' => 1251,
                'SourceType' => 'ACCREC',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $journals = $client->accounting()->journals()
            ->modifiedSince(new DateTimeImmutable('2026-03-25T00:00:00+00:00'))
            ->offset(1200)
            ->paymentsOnly()
            ->get();

        $journal = $client->accounting()->journals()->find('journal-1');
        $journalByNumber = $client->accounting()->journals()->number(1251);

        self::assertSame('/api.xro/2.0/Journals', $transport->requests()[0]->path);
        self::assertSame('Wed, 25 Mar 2026 00:00:00 GMT', $transport->requests()[0]->query['If-Modified-Since']);
        self::assertSame(1200, $transport->requests()[0]->query['offset']);
        self::assertSame('true', $transport->requests()[0]->query['paymentsOnly']);
        self::assertInstanceOf(Journal::class, $journals->first());
        self::assertSame('/api.xro/2.0/Journals/journal-1', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/Journals/1251', $transport->requests()[2]->path);
        self::assertSame(1251, $journalByNumber?->getJournalNumber());
        self::assertSame('journal-1', $journal?->getJournalID());
        self::assertSame('ACCPAY', $journal->getSourceType());
        self::assertSame('source-1', $journal->getSourceID());
        self::assertSame('2026-03-25T00:00:00', $journal->getJournalDate());
        self::assertSame('2026-03-25T01:00:00', $journal->getCreatedDateUTC());
        self::assertSame('INV-001', $journal->getReference());
        $journalLine = $journal->getJournalLines()[0];
        self::assertSame('line-1', $journalLine->getJournalLineID());
        self::assertSame('account-1', $journalLine->getAccountID());
        self::assertSame('200', $journalLine->getAccountCode());
        self::assertSame('REVENUE', $journalLine->getAccountType());
        self::assertSame('Sales', $journalLine->getAccountName());
        self::assertSame('Sale of goods', $journalLine->getDescription());
        self::assertSame(100, $journalLine->getNetAmount());
        self::assertSame(115, $journalLine->getGrossAmount());
        self::assertSame(15, $journalLine->getTaxAmount());
        self::assertSame('OUTPUT2', $journalLine->getTaxType());
        self::assertSame('GST on Income', $journalLine->getTaxName());
        self::assertSame('category-1', $journalLine->getTrackingCategories()[0]->getTrackingCategoryID());
        self::assertNotSame([], $client->accounting()->journals()->scopes()->granular);
    }

    public function test_it_can_list_and_fetch_reports(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Reports' => [[
                'ReportID' => 'report-1',
                'ReportName' => 'Profit and Loss',
                'ReportType' => 'ProfitAndLoss',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Reports' => [[
                'ReportID' => 'report-2',
                'ReportName' => 'Custom Report',
                'ReportTitles' => ['Custom Report'],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Reports' => [[
                'ReportID' => 'report-pl',
                'ReportName' => 'Profit and Loss',
                'ReportTitles' => ['Profit and Loss'],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Reports' => [[
                'ReportID' => 'report-ar',
                'ReportName' => 'Aged Receivables By Contact',
                'ReportTitles' => ['Aged Receivables By Contact'],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $reports = $client->accounting()->reports()->list();
        $custom = $client->accounting()->reports()->find('report-2');
        $profitAndLoss = $client->accounting()->reports()->profitAndLoss([
            'fromDate' => new DateTimeImmutable('2026-01-01'),
            'toDate' => new DateTimeImmutable('2026-03-25'),
            'paymentsOnly' => true,
        ]);
        $agedReceivables = $client->accounting()->reports()->agedReceivablesByContact('contact-1', [
            'date' => new DateTimeImmutable('2026-03-25'),
        ]);

        self::assertSame('/api.xro/2.0/Reports', $transport->requests()[0]->path);
        self::assertInstanceOf(Report::class, $reports->first());
        self::assertSame('/api.xro/2.0/Reports/report-2', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/Reports/ProfitAndLoss', $transport->requests()[2]->path);
        self::assertSame('2026-01-01', $transport->requests()[2]->query['fromDate']);
        self::assertSame('2026-03-25', $transport->requests()[2]->query['toDate']);
        self::assertSame('true', $transport->requests()[2]->query['paymentsOnly']);
        self::assertSame('/api.xro/2.0/Reports/AgedReceivablesByContact', $transport->requests()[3]->path);
        self::assertSame('contact-1', $transport->requests()[3]->query['contactId']);
        self::assertSame('2026-03-25', $transport->requests()[3]->query['date']);
        self::assertSame('Custom Report', $custom?->getTitle());
        self::assertSame('Profit and Loss', $profitAndLoss?->getTitle());
        self::assertSame('Aged Receivables By Contact', $agedReceivables?->getTitle());
    }

    public function test_it_can_fetch_every_named_report_type(): void
    {
        $transport = new FakeTransport();
        for ($i = 0; $i < 7; $i++) {
            $transport->push(new Response(200, body: json_encode([
                'Reports' => [[
                    'ReportID' => 'report-' . $i,
                    'ReportName' => 'Report ' . $i,
                    'ReportType' => 'Type' . $i,
                ]],
            ], JSON_THROW_ON_ERROR)));
        }

        $reports = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->reports();

        $balanceSheet = $reports->balanceSheet(['date' => new DateTimeImmutable('2026-03-25'), 'periods' => null]);
        $reports->trialBalance();
        $reports->bankSummary();
        $reports->budgetSummary();
        $reports->executiveSummary();
        $reports->agedPayablesByContact('contact-9');
        $reports->tenNinetyNine(['financialYear' => 2026]);

        $paths = array_map(static fn ($r): string => $r->path, $transport->requests());

        self::assertSame('/api.xro/2.0/Reports/BalanceSheet', $paths[0]);
        self::assertSame('/api.xro/2.0/Reports/TrialBalance', $paths[1]);
        self::assertSame('/api.xro/2.0/Reports/BankSummary', $paths[2]);
        self::assertSame('/api.xro/2.0/Reports/BudgetSummary', $paths[3]);
        self::assertSame('/api.xro/2.0/Reports/ExecutiveSummary', $paths[4]);
        self::assertSame('/api.xro/2.0/Reports/AgedPayablesByContact', $paths[5]);
        self::assertSame('contact-9', $transport->requests()[5]->query['contactId']);
        self::assertSame('/api.xro/2.0/Reports/TenNinetyNine', $paths[6]);

        // null query values are skipped by normalizeQuery.
        self::assertArrayNotHasKey('periods', $transport->requests()[0]->query);

        self::assertSame('report-0', $balanceSheet?->getReportID());
        self::assertSame('Report 0', $balanceSheet->getReportName());
        self::assertSame('Type0', $balanceSheet->getReportType());

        self::assertSame(['accounting.reports.read'], $reports->scopes()->granular);
    }
}
