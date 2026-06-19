<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendar;
use Sujip\Xero\Xero;

final class PayRunCalendarsTest extends TestCase
{
    public function test_it_can_query_and_find_pay_run_calendars(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'payRunCalendars' => [[
                'payrollCalendarID' => 'calendar-1',
                'name' => 'Fortnightly',
                'calendarType' => 'Fortnightly',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'payRunCalendar' => [
                'payrollCalendarID' => 'calendar-1',
                'name' => 'Fortnightly',
                'calendarType' => 'Fortnightly',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $calendars = $client->payroll()->nz()->payRunCalendars()->page(2)->get();
        $calendar = $client->payroll()->nz()->payRunCalendars()->find('calendar-1');

        self::assertSame('/payroll.xro/2.0/PayRunCalendars', $transport->requests()[0]->path);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(PayRunCalendar::class, $calendars->first());
        self::assertSame('/payroll.xro/2.0/PayRunCalendars/calendar-1', $transport->requests()[1]->path);
        self::assertSame('calendar-1', $calendar?->getPayrollCalendarID());
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->payRunCalendars()
            ->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }

    public function test_it_can_paginate_pay_run_calendars(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['payRunCalendars' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->payRunCalendars()
            ->paginate(page: 2, perPage: 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
    }

    public function test_pay_run_calendar_exposes_all_fields(): void
    {
        $calendar = (new PayRunCalendar())->fill([
            'payrollCalendarID' => 'calendar-1',
            'name' => 'Fortnightly',
            'calendarType' => 'Fortnightly',
            'periodStartDate' => '2026-04-01',
            'periodEndDate' => '2026-04-14',
            'paymentDate' => '2026-04-15',
            'updatedDateUTC' => '2026-04-15T00:00:00',
        ]);

        self::assertSame('calendar-1', $calendar->getPayrollCalendarID());
        self::assertSame('Fortnightly', $calendar->getName());
        self::assertSame('Fortnightly', $calendar->getCalendarType());
        self::assertSame('2026-04-01', $calendar->getPeriodStartDate());
        self::assertSame('2026-04-14', $calendar->getPeriodEndDate());
        self::assertSame('2026-04-15', $calendar->getPaymentDate());
        self::assertSame('2026-04-15T00:00:00', $calendar->getUpdatedDateUTC());
    }
}
