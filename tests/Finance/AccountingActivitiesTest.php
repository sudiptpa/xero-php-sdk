<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Finance\AccountingActivity\AccountingActivity;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class AccountingActivitiesTest extends TestCase
{
    public function test_it_can_get_accounting_activities(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Items' => [[
                'Month' => '2026-03',
                'TotalIncome' => 1500,
                'TotalExpense' => 400,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $activities = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->finance()
            ->accountingActivities()
            ->get(new DateTimeImmutable('2026-03-01'), new DateTimeImmutable('2026-03-31'));

        self::assertSame('/finance.xro/1.0/AccountingActivities', $transport->requests()[0]->path);
        self::assertSame('2026-03-01', $transport->requests()[0]->query['startDate']);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['endDate']);
        self::assertInstanceOf(AccountingActivity::class, $activities->first());
    }
}
