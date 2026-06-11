<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\PayRun\PayRun;
use Sujip\Xero\Payroll\AU\PayRun\Payslip;
use Sujip\Xero\Xero;

final class PayRunsTest extends TestCase
{
    public function test_it_can_query_find_create_and_update_pay_runs(): void
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
        $transport->push(new Response(200, body: json_encode([
            'PayRun' => [
                'PayRunID' => 'payrun-2',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'POSTED',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $runs = $client->payroll()->au()->payRuns()
            ->modifiedSince(new DateTimeImmutable('2026-03-26T00:00:00+00:00'))
            ->where('Status=="DRAFT"')
            ->orderBy('PaymentDate DESC')
            ->page(2)
            ->get();

        $run = $client->payroll()->au()->payRuns()->find('payrun-1');
        $created = $client->payroll()->au()->payRuns()->create()->payrollCalendar('calendar-1')->save();
        $updated = $client->payroll()->au()->payRuns()->update('payrun-2')->payrollCalendar('calendar-1')->save();

        self::assertSame('/payroll.xro/1.0/PayRuns', $transport->requests()[0]->path);
        self::assertSame('Status=="DRAFT"', $transport->requests()[0]->query['where']);
        self::assertSame('PaymentDate DESC', $transport->requests()[0]->query['order']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(PayRun::class, $runs->first());
        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/PayRuns', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-2', $transport->requests()[3]->path);
        self::assertSame('payrun-1', $run?->getPayRunID());
        self::assertSame('payrun-2', $updated->getPayRunID());
        self::assertSame('payrun-2', $created->getPayRunID());
    }

    public function test_it_can_load_payrun_payslips(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PayRun' => [
                'PayRunID' => 'payrun-1',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'POSTED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Payslips' => [[
                'PayslipID' => 'payslip-1',
                'EmployeeID' => 'employee-1',
                'NetPay' => 1200.55,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Payslip' => [
                'PayslipID' => 'payslip-1',
                'EmployeeID' => 'employee-1',
                'NetPay' => 1200.55,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Payslips' => [[
                'PayslipID' => 'payslip-1',
                'EmployeeID' => 'employee-1',
                'NetPay' => 1200.55,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $payRun = $client->payroll()->au()->payRuns()->find('payrun-1');
        $payslips = $client->payroll()->au()->payRuns()->payslips('payrun-1')->get();
        $payslip = $client->payroll()->au()->payRuns()->payslips('payrun-1')->find('payslip-1');
        $modelPayslips = $payRun?->payslips();

        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-1', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-1/Payslips', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-1/Payslips/payslip-1', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-1/Payslips', $transport->requests()[3]->path);
        self::assertInstanceOf(Payslip::class, $payslips->first());
        self::assertSame('payslip-1', $payslip?->getPayslipID());
        self::assertSame('payslip-1', $modelPayslips?->first()?->getPayslipID());
    }

    public function test_it_exposes_scopes(): void
    {
        $payRuns = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payRuns();

        $scopes = $payRuns->scopes();
        $payslipScopes = $payRuns->payslips('payrun-1')->scopes();

        self::assertSame(['payroll.payruns'], $scopes->broad);
        self::assertSame(['payroll.payruns.read', 'payroll.payruns'], $scopes->granular);
        self::assertSame(['payroll.payruns'], $payslipScopes->broad);
        self::assertSame(['payroll.payruns.read', 'payroll.payruns'], $payslipScopes->granular);
    }

    public function test_it_can_paginate_pay_runs(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['PayRuns' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
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
            'PaymentDate' => '/Date(1573430400000+0000)/',
        ]);

        self::assertSame('payrun-1', $payRun->getPayRunID());
        self::assertSame('calendar-1', $payRun->getPayrollCalendarID());
        self::assertSame('POSTED', $payRun->getPayRunStatus());
        self::assertSame('/Date(1573430400000+0000)/', $payRun->getPaymentDate());
    }

    public function test_it_can_save_a_found_pay_run(): void
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
            'PayRuns' => [[
                'PayRunID' => 'payrun-1',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'POSTED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $payRun = $client->payroll()->au()->payRuns()->find('payrun-1');
        $saved = $payRun?->setPayRunStatus('POSTED')->save();

        self::assertSame('POST', $transport->requests()[1]->method);
        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-1', $transport->requests()[1]->path);
        self::assertSame([
            'PayRuns' => [[
                'PayrollCalendarID' => 'calendar-1',
                'PayRunID' => 'payrun-1',
            ]],
        ], $transport->requests()[1]->json);
        self::assertSame('POSTED', $saved?->getPayRunStatus());
    }

    public function test_pay_run_save_requires_client(): void
    {
        $this->expectException(RuntimeException::class);

        (new PayRun())->save();
    }

    public function test_pay_run_payslips_require_client_and_pay_run_id(): void
    {
        $this->expectException(RuntimeException::class);

        (new PayRun())->payslips();
    }

    public function test_it_sends_idempotency_key_and_returns_blank_pay_run_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $payRun = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payRuns()
            ->create()
            ->payrollCalendar('calendar-1')
            ->idempotencyKey('key-123')
            ->save();

        self::assertSame('key-123', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertNull($payRun->getPayRunID());
    }

    public function test_payslip_exposes_all_fields(): void
    {
        $payslip = (new Payslip())->fill([
            'PayslipID' => 'payslip-1',
            'EmployeeID' => 'employee-1',
            'PaymentDate' => '/Date(1573430400000+0000)/',
            'NetPay' => '1200.55',
        ]);

        self::assertSame('payslip-1', $payslip->getPayslipID());
        self::assertSame('employee-1', $payslip->getEmployeeID());
        self::assertSame('/Date(1573430400000+0000)/', $payslip->getPaymentDate());
        self::assertSame('1200.55', $payslip->getNetPay());
    }
}
