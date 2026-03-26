<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendar;
use Sujip\Xero\Xero;

final class PayRunCalendarsTest extends TestCase
{
    public function test_it_can_query_and_find_pay_run_calendars(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PayRunCalendars' => [[
                'PayrollCalendarID' => 'calendar-1',
                'Name' => 'Monthly',
                'CalendarType' => 'MONTHLY',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PayRunCalendar' => [
                'PayrollCalendarID' => 'calendar-1',
                'Name' => 'Monthly',
                'CalendarType' => 'MONTHLY',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $calendars = $client->payroll()->uk()->payRunCalendars()->page(2)->get();
        $calendar = $client->payroll()->uk()->payRunCalendars()->find('calendar-1');

        self::assertSame('/payroll.xro/2.0/PayRunCalendars', $transport->requests()[0]->path);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(PayRunCalendar::class, $calendars->first());
        self::assertSame('/payroll.xro/2.0/PayRunCalendars/calendar-1', $transport->requests()[1]->path);
        self::assertSame('calendar-1', $calendar?->id);
    }
}
