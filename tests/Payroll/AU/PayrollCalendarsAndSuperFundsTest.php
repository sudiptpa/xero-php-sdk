<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\PayrollCalendar\PayrollCalendar;
use Sujip\Xero\Payroll\AU\SuperFund\Product;
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
        self::assertNotNull($calendars->first());
        self::assertSame('calendar-1', $calendar?->getPayrollCalendarID());
        self::assertSame('calendar-2', $created->getPayrollCalendarID());
        self::assertSame('calendar-2', $updated->getPayrollCalendarID());
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
        $transport->push(new Response(200, body: json_encode([
            'SuperFund' => [
                'SuperFundID' => 'fund-2',
                'Name' => 'Future Super',
                'Type' => 'REGULATED',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $funds = $client->payroll()->au()->superFunds()->get();
        $fund = $client->payroll()->au()->superFunds()->find('fund-1');
        $created = $client->payroll()->au()->superFunds()->create()
            ->type('REGULATED')
            ->name('Future Super')
            ->uSI('40022701955002')
            ->abn('12345678901')
            ->idempotencyKey('superfund-key')
            ->save();

        self::assertSame('/payroll.xro/1.0/SuperFunds', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/1.0/SuperFunds/fund-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/SuperFunds', $transport->requests()[2]->path);
        self::assertSame('superfund-key', $transport->requests()[2]->headers['Idempotency-Key']);
        $json2 = $transport->requests()[2]->json ?? [];
        self::assertSame('40022701955002', $json2['USI'] ?? null);
        self::assertNotNull($funds->first());
        self::assertSame('fund-1', $fund?->getSuperFundID());
        self::assertSame('fund-2', $created->getSuperFundID());
    }

    public function test_it_can_load_super_fund_products(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'SuperFundProducts' => [[
                'SuperFundProductID' => 'product-1',
                'Name' => 'Balanced',
                'USI' => 'OSF0001AU',
                'ABN' => '40022701955',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $products = $client->payroll()->au()->superFundProducts()
            ->abn('40022701955')
            ->usi('OSF0001AU')
            ->get();

        self::assertSame('/payroll.xro/1.0/SuperFundProducts', $transport->requests()[0]->path);
        self::assertSame('40022701955', $transport->requests()[0]->query['ABN']);
        self::assertSame('OSF0001AU', $transport->requests()[0]->query['USI']);
        $firstProduct = $products->first();
        self::assertNotNull($firstProduct);
        self::assertSame('product-1', $firstProduct->getSuperFundProductID());
    }
}
