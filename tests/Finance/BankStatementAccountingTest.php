<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Finance\BankStatementEntry;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class BankStatementAccountingTest extends TestCase
{
    public function test_it_can_get_bank_statement_accounting(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'bankAccountId' => 'account-1',
            'bankAccountName' => 'Main Account',
            'statements' => [[
                'statementId' => 'statement-1',
                'startDate' => '2026-03-01',
                'endDate' => '2026-03-31',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $entries = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->finance()
            ->bankStatementAccounting()
            ->get('account-1', new DateTimeImmutable('2026-03-01'), new DateTimeImmutable('2026-03-31'), summaryOnly: true);

        self::assertSame('/finance.xro/1.0/BankStatementsPlus/statements', $transport->requests()[0]->path);
        self::assertSame('account-1', $transport->requests()[0]->query['BankAccountID']);
        self::assertSame('2026-03-01', $transport->requests()[0]->query['FromDate']);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['ToDate']);
        self::assertTrue($transport->requests()[0]->query['SummaryOnly']);
        self::assertInstanceOf(BankStatementEntry::class, $entries->first());
    }
}
