<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Finance\AccountingActivity\AccountingActivity;
use Sujip\Xero\Finance\AccountingActivity\LockHistory;
use Sujip\Xero\Finance\AccountingActivity\UserActivity;
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

    public function test_it_can_get_lock_history_and_user_activities(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'LockDate' => '2026-03-31',
                'LockType' => 'SOFTLOCK',
                'ChangedDateUTC' => '2026-03-25T00:00:00',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'UserId' => 'user-1',
                'FullName' => 'Jane Doe',
                'TransactionCount' => 14,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $lockHistory = $client->finance()
            ->accountingActivities()
            ->lockHistory(new DateTimeImmutable('2026-03-31'));

        $userActivities = $client->finance()
            ->accountingActivities()
            ->userActivities('2026-02');

        self::assertSame('/finance.xro/1.0/AccountingActivities/LockHistory', $transport->requests()[0]->path);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['endDate']);
        self::assertInstanceOf(LockHistory::class, $lockHistory->first());
        self::assertSame('/finance.xro/1.0/AccountingActivities/UserActivities', $transport->requests()[1]->path);
        self::assertSame('2026-02', $transport->requests()[1]->query['dataMonth']);
        self::assertInstanceOf(UserActivity::class, $userActivities->first());
    }
}
