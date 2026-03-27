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
            'Items' => [[
                'AccountID' => 'account-1',
                'AccountName' => 'Main Account',
                'StatementBalance' => 1500.25,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $entries = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->finance()
            ->bankStatementAccounting()
            ->get(new DateTimeImmutable('2026-03-31'), new DateTimeImmutable('2026-03-31'));

        self::assertSame('/finance.xro/1.0/BankStatementAccounting', $transport->requests()[0]->path);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['balanceDate']);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['asAtSystemDate']);
        self::assertInstanceOf(BankStatementEntry::class, $entries->first());
    }
}
