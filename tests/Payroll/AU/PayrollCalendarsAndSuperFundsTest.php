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
    public function test_it_can_query_find_create_and_paginate_payroll_calendars(): void
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
            ->idempotencyKey('calendar-key')
            ->save();
        $page = $client->payroll()->au()->payrollCalendars()->paginate(page: 3, perPage: 25);

        self::assertSame('/payroll.xro/1.0/PayrollCalendars', $transport->requests()[0]->path);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame('/payroll.xro/1.0/PayrollCalendars/calendar-1', $transport->requests()[1]->path);
        self::assertSame('POST', $transport->requests()[2]->method);
        self::assertSame('/payroll.xro/1.0/PayrollCalendars', $transport->requests()[2]->path);
        self::assertSame('calendar-key', $transport->requests()[2]->headers['Idempotency-Key']);
        self::assertSame('/payroll.xro/1.0/PayrollCalendars', $transport->requests()[3]->path);
        self::assertSame(3, $transport->requests()[3]->query['page']);
        self::assertSame(25, $transport->requests()[3]->query['pageSize']);
        self::assertNotNull($calendars->first());
        self::assertSame('calendar-1', $calendar?->getPayrollCalendarID());
        self::assertSame('calendar-2', $created->getPayrollCalendarID());
        self::assertSame(3, $page->page);
    }

    public function test_payroll_calendars_expose_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payrollCalendars()
            ->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }

    public function test_payroll_calendar_exposes_all_fields(): void
    {
        $calendar = (new PayrollCalendar())->fill([
            'PayrollCalendarID' => 'calendar-1',
            'Name' => 'Weekly',
            'CalendarType' => 'WEEKLY',
            'StartDate' => '/Date(1572566400000+0000)/',
            'PaymentDate' => '/Date(1573171200000+0000)/',
            'UpdatedDateUTC' => '/Date(1584125518633+0000)/',
            'ReferenceDate' => '/Date(1573171200000+0000)/',
            'ValidationErrors' => [['Message' => 'Invalid calendar']],
        ]);

        self::assertSame('calendar-1', $calendar->getPayrollCalendarID());
        self::assertSame('Weekly', $calendar->getName());
        self::assertSame('WEEKLY', $calendar->getCalendarType());
        self::assertSame('/Date(1572566400000+0000)/', $calendar->getStartDate());
        self::assertSame('/Date(1573171200000+0000)/', $calendar->getPaymentDate());
        self::assertSame('/Date(1584125518633+0000)/', $calendar->getUpdatedDateUtc());
        self::assertSame('/Date(1573171200000+0000)/', $calendar->getReferenceDate());
        $errors = $calendar->getValidationErrors();
        self::assertCount(1, $errors);
        self::assertSame('Invalid calendar', $errors[0]->getMessage());
    }

    public function test_payroll_calendar_save_returns_blank_model_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $calendar = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payrollCalendars()
            ->create()
            ->name('Weekly')
            ->save();

        self::assertNull($calendar->getPayrollCalendarID());
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
            ->bsb('484-799')
            ->accountNumber('123456789')
            ->accountName('Super Account')
            ->electronicServiceAddress('FUTURESUPER')
            ->employerNumber('EMP-1')
            ->spin('FSF0001AU')
            ->idempotencyKey('superfund-key')
            ->save();

        self::assertSame('/payroll.xro/1.0/SuperFunds', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/1.0/SuperFunds/fund-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/SuperFunds', $transport->requests()[2]->path);
        self::assertSame('superfund-key', $transport->requests()[2]->headers['Idempotency-Key']);
        $json2 = $transport->requests()[2]->json ?? [];
        self::assertSame('40022701955002', $json2['USI'] ?? null);
        self::assertSame('484-799', $json2['BSB'] ?? null);
        self::assertSame('123456789', $json2['AccountNumber'] ?? null);
        self::assertSame('Super Account', $json2['AccountName'] ?? null);
        self::assertSame('FUTURESUPER', $json2['ElectronicServiceAddress'] ?? null);
        self::assertSame('EMP-1', $json2['EmployerNumber'] ?? null);
        self::assertSame('FSF0001AU', $json2['SPIN'] ?? null);
        self::assertNotNull($funds->first());
        self::assertSame('fund-1', $fund?->getSuperFundID());
        self::assertSame('fund-2', $created->getSuperFundID());
    }

    public function test_it_can_load_super_fund_products(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'SuperFundProducts' => [[
                'USI' => 'OSF0001AU',
                'ABN' => '40022701955',
                'SPIN' => 'NML0117AU',
                'ProductName' => 'Balanced',
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
        self::assertSame('Balanced', $firstProduct->getProductName());
        self::assertSame('NML0117AU', $firstProduct->getSpin());
    }

    public function test_super_funds_and_products_expose_scopes(): void
    {
        $payroll = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au();

        $fundScopes = $payroll->superFunds()->scopes();
        $productScopes = $payroll->superFundProducts()->scopes();

        self::assertSame(['payroll.settings'], $fundScopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $fundScopes->granular);
        self::assertSame(['payroll.settings'], $productScopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $productScopes->granular);
    }

    public function test_super_fund_exposes_all_fields(): void
    {
        $fund = (new SuperFund())->fill([
            'SuperFundID' => 'fund-1',
            'Type' => 'REGULATED',
            'Name' => 'AustralianSuper',
            'ABN' => '24248426878',
            'BSB' => '484799',
            'AccountNumber' => '123456789',
            'AccountName' => 'Money account',
            'ElectronicServiceAddress' => '12345678',
            'EmployerNumber' => '324324',
            'SPIN' => '4545445454',
            'USI' => '40022701955001',
            'UpdatedDateUTC' => '/Date(1583967733054+0000)/',
            'ValidationErrors' => [['Message' => 'Invalid ABN']],
        ]);

        self::assertSame('fund-1', $fund->getSuperFundID());
        self::assertSame('REGULATED', $fund->getType());
        self::assertSame('AustralianSuper', $fund->getName());
        self::assertSame('24248426878', $fund->getAbn());
        self::assertSame('484799', $fund->getBsb());
        self::assertSame('123456789', $fund->getAccountNumber());
        self::assertSame('Money account', $fund->getAccountName());
        self::assertSame('12345678', $fund->getElectronicServiceAddress());
        self::assertSame('324324', $fund->getEmployerNumber());
        self::assertSame('4545445454', $fund->getSpin());
        self::assertSame('40022701955001', $fund->getUsi());
        self::assertSame('/Date(1583967733054+0000)/', $fund->getUpdatedDateUtc());
        $errors = $fund->getValidationErrors();
        self::assertCount(1, $errors);
        self::assertSame('Invalid ABN', $errors[0]->getMessage());
    }

    public function test_super_fund_product_exposes_all_fields(): void
    {
        $product = (new Product())->fill([
            'ABN' => '40022701955',
            'USI' => 'OSF0001AU',
            'SPIN' => 'NML0117AU',
            'ProductName' => 'Balanced',
        ]);

        self::assertSame('40022701955', $product->getAbn());
        self::assertSame('OSF0001AU', $product->getUsi());
        self::assertSame('NML0117AU', $product->getSpin());
        self::assertSame('Balanced', $product->getProductName());
    }

    public function test_super_fund_save_returns_blank_model_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $fund = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->superFunds()
            ->create()
            ->name('AustralianSuper')
            ->save();

        self::assertNull($fund->getSuperFundID());
    }
}
