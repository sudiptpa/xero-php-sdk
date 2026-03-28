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
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Journals' => [[
                'JournalID' => 'journal-1',
                'JournalNumber' => 1250,
                'SourceType' => 'ACCPAY',
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
}
