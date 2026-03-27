<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar;
use Sujip\Xero\Payroll\AU\SuperFund\SuperFund;
use Sujip\Xero\Xero;

final class PayrollCalendarsAndSuperFundsTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_paginate_payroll_calendars(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PayrollCalendars' => [[
                'PayrollCalendarID' => 'calendar-1',
                'Name' => 'Weekly',
                'CalendarType' => 'WEEKLY',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PayrollCalendar' => [
                'PayrollCalendarID' => 'calendar-1',
                'Name' => 'Weekly',
                'CalendarType' => 'WEEKLY',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PayrollCalendar' => [
                'PayrollCalendarID' => 'calendar-2',
                'Name' => 'Fortnightly',
                'CalendarType' => 'FORTNIGHTLY',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PayrollCalendar' => [
                'PayrollCalendarID' => 'calendar-2',
                'Name' => 'Fortnightly',
                'CalendarType' => 'FORTNIGHTLY',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PayrollCalendars' => [],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $calendars = $client->payroll()->au()->payrollCalendars()->page(2)->get();
        $calendar = $client->payroll()->au()->payrollCalendars()->find('calendar-1');
        $created = $client->payroll()->au()->payrollCalendars()->create()
            ->name('Fortnightly')
            ->calendarType('FORTNIGHTLY')
            ->startDate('2026-04-01')
            ->paymentDate('2026-04-08')
            ->save();
        $updated = $client->payroll()->au()->payrollCalendars()->update('calendar-2')
            ->name('Fortnightly')
            ->calendarType('FORTNIGHTLY')
            ->save();
        $page = $client->payroll()->au()->payrollCalendars()->paginate(page: 3, perPage: 25);

        self::assertSame('/payroll.xro/1.0/PayrollCalendars', $transport->requests()[0]->path);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame('/payroll.xro/1.0/PayrollCalendars/calendar-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/PayrollCalendars', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/1.0/PayrollCalendars/calendar-2', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/1.0/PayrollCalendars', $transport->requests()[4]->path);
        self::assertSame(3, $transport->requests()[4]->query['page']);
        self::assertSame(25, $transport->requests()[4]->query['pageSize']);
        self::assertInstanceOf(PayrollCalendar::class, $calendars->first());
        self::assertSame('calendar-1', $calendar?->id);
        self::assertSame('calendar-2', $created->id);
        self::assertSame('calendar-2', $updated->id);
        self::assertSame(3, $page->page);
    }

    public function test_it_can_load_super_funds(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'SuperFunds' => [[
                'SuperFundID' => 'fund-1',
                'Name' => 'AustralianSuper',
                'Type' => 'REGULATED',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'SuperFund' => [
                'SuperFundID' => 'fund-1',
                'Name' => 'AustralianSuper',
                'Type' => 'REGULATED',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $funds = $client->payroll()->au()->superFunds()->get();
        $fund = $client->payroll()->au()->superFunds()->find('fund-1');

        self::assertSame('/payroll.xro/1.0/SuperFunds', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/1.0/SuperFunds/fund-1', $transport->requests()[1]->path);
        self::assertInstanceOf(SuperFund::class, $funds->first());
        self::assertSame('fund-1', $fund?->id);
    }
}
