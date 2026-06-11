<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\PayRun\PayRun;
use Sujip\Xero\Xero;

final class PayRunsTest extends TestCase
{
    public function test_it_can_query_find_and_create_pay_runs(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PayRuns' => [[
                'PayRunID' => 'payrun-1',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'DRAFT',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PayRun' => [
                'PayRunID' => 'payrun-1',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PayRun' => [
                'PayRunID' => 'payrun-2',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $runs = $client->payroll()->nz()->payRuns()->status('draft')->page(2)->get();
        $run = $client->payroll()->nz()->payRuns()->find('payrun-1');
        $created = $client->payroll()->nz()->payRuns()->create()->payrollCalendar('calendar-1')->save();

        self::assertSame('/payroll.xro/2.0/PayRuns', $transport->requests()[0]->path);
        self::assertSame('DRAFT', $transport->requests()[0]->query['status']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(PayRun::class, $runs->first());
        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/PayRuns', $transport->requests()[2]->path);
        self::assertSame('payrun-1', $run?->getPayRunID());
        self::assertSame('payrun-2', $created->getPayRunID());
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->payRuns()
            ->scopes();

        self::assertSame(['payroll.payruns'], $scopes->broad);
        self::assertSame(['payroll.payruns.read', 'payroll.payruns'], $scopes->granular);
    }

    public function test_it_can_paginate_pay_runs(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['PayRuns' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->payRuns()
            ->paginate(page: 2, perPage: 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
    }

    public function test_pay_run_exposes_all_fields(): void
    {
        $payRun = (new PayRun())->fill([
            'PayRunID' => 'payrun-1',
            'PayrollCalendarID' => 'calendar-1',
            'PayRunStatus' => 'POSTED',
            'PaymentDate' => '2026-04-08',
        ]);

        self::assertSame('payrun-1', $payRun->getPayRunID());
        self::assertSame('calendar-1', $payRun->getPayrollCalendarID());
        self::assertSame('POSTED', $payRun->getPayRunStatus());
        self::assertSame('2026-04-08', $payRun->getPaymentDate());
    }

    public function test_it_sends_idempotency_key_and_returns_blank_pay_run_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $payRun = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->payRuns()
            ->create()
            ->payrollCalendar('calendar-1')
            ->idempotencyKey('key-123')
            ->save();

        self::assertSame('key-123', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertNull($payRun->getPayRunID());
    }
}
