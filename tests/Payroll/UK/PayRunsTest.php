<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\PayRun\PayRun;
use Sujip\Xero\Payroll\UK\PayRun\Payslip;
use Sujip\Xero\Xero;

final class PayRunsTest extends TestCase
{
    public function test_it_can_query_find_and_create_pay_runs(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'payRuns' => [[
                'payRunID' => 'payrun-1',
                'payrollCalendarID' => 'calendar-1',
                'payRunStatus' => 'Draft',
                'periodStartDate' => '2026-03-01',
                'periodEndDate' => '2026-03-31',
                'totalCost' => 1500.25,
                'totalPay' => 1200.55,
                'payRunType' => 'Scheduled',
                'calendarType' => 'Monthly',
                'postedDateTime' => '2026-03-31',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'payRun' => [
                'payRunID' => 'payrun-1',
                'payrollCalendarID' => 'calendar-1',
                'payRunStatus' => 'Draft',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'payRun' => [
                'payRunID' => 'payrun-2',
                'payrollCalendarID' => 'calendar-1',
                'payRunStatus' => 'Draft',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $runs = $client->payroll()->uk()->payRuns()->status('Draft')->page(2)->get();
        $run = $client->payroll()->uk()->payRuns()->find('payrun-1');
        $created = $client->payroll()->uk()->payRuns()->create()
            ->payrollCalendar('calendar-1')
            ->paymentDate('2026-04-05')
            ->save();

        self::assertSame('/payroll.xro/2.0/PayRuns', $transport->requests()[0]->path);
        self::assertSame('Draft', $transport->requests()[0]->query['status']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        $firstRun = $runs->first();
        self::assertNotNull($firstRun);
        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/PayRuns', $transport->requests()[2]->path);
        self::assertSame([
            'payrollCalendarID' => 'calendar-1',
            'paymentDate' => '2026-04-05',
        ], $transport->requests()[2]->json);
        self::assertSame('payrun-1', $run?->getPayRunID());
        self::assertSame('payrun-2', $created->getPayRunID());
        self::assertSame('2026-03-01', $firstRun->getPeriodStartDate());
        self::assertSame(1500.25, $firstRun->getTotalCost());
        self::assertSame('Scheduled', $firstRun->getPayRunType());
    }

    public function test_it_can_load_payrun_payslips(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'payRun' => [
                'payRunID' => 'payrun-1',
                'payrollCalendarID' => 'calendar-1',
                'payRunStatus' => 'Posted',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'paySlips' => [[
                'paySlipID' => 'payslip-1',
                'employeeID' => 'employee-1',
                'totalPay' => 1200.55,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'paySlip' => [
                'paySlipID' => 'payslip-1',
                'employeeID' => 'employee-1',
                'totalPay' => 1200.55,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'paySlips' => [[
                'paySlipID' => 'payslip-1',
                'employeeID' => 'employee-1',
                'totalPay' => 1200.55,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $payRun = $client->payroll()->uk()->payRuns()->find('payrun-1');
        $payslips = $client->payroll()->uk()->payRuns()->payslips('payrun-1')->get();
        $payslip = $client->payroll()->uk()->payRuns()->payslips('payrun-1')->find('payslip-1');
        $modelPayslips = $payRun?->payslips();

        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/2.0/Payslips', $transport->requests()[1]->path);
        self::assertSame('payrun-1', $transport->requests()[1]->query['PayRunID']);
        self::assertSame('/payroll.xro/2.0/Payslips/payslip-1', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/2.0/Payslips', $transport->requests()[3]->path);
        self::assertSame('payrun-1', $transport->requests()[3]->query['PayRunID']);
        self::assertNotNull($payslips->first());
        self::assertSame('payslip-1', $payslip?->getPayslipID());
        self::assertSame('payslip-1', $modelPayslips?->first()?->getPayslipID());
    }

    public function test_it_exposes_scopes(): void
    {
        $payRuns = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
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
            new Response(200, body: json_encode(['payRuns' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
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
            'payRunID' => 'payrun-1',
            'payrollCalendarID' => 'calendar-1',
            'payRunStatus' => 'Posted',
            'paymentDate' => '2026-04-05',
            'periodStartDate' => '2026-03-01',
            'periodEndDate' => '2026-03-31',
            'totalCost' => 1500.25,
            'totalPay' => 1200.55,
            'payRunType' => 'Scheduled',
            'calendarType' => 'Monthly',
            'postedDateTime' => '2026-03-31T12:00:00',
            'paySlips' => [
                ['paySlipID' => 'payslip-1', 'employeeID' => 'employee-1'],
            ],
        ]);

        self::assertSame('payrun-1', $payRun->getPayRunID());
        self::assertSame('calendar-1', $payRun->getPayrollCalendarID());
        self::assertSame('Posted', $payRun->getPayRunStatus());
        self::assertSame('2026-04-05', $payRun->getPaymentDate());
        self::assertSame('2026-03-01', $payRun->getPeriodStartDate());
        self::assertSame('2026-03-31', $payRun->getPeriodEndDate());
        self::assertSame(1500.25, $payRun->getTotalCost());
        self::assertSame(1200.55, $payRun->getTotalPay());
        self::assertSame('Scheduled', $payRun->getPayRunType());
        self::assertSame('Monthly', $payRun->getCalendarType());
        self::assertSame('2026-03-31T12:00:00', $payRun->getPostedDateTime());

        $paySlips = $payRun->getPaySlips();
        self::assertCount(1, $paySlips);
        self::assertSame('payslip-1', $paySlips[0]->getPayslipID());
        self::assertSame('employee-1', $paySlips[0]->getEmployeeID());
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
            ->uk()
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
            'paySlipID' => 'payslip-1',
            'employeeID' => 'employee-1',
            'payRunID' => 'payrun-1',
            'lastEdited' => '2026-04-05T00:00:00',
            'firstName' => 'Ada',
            'lastName' => 'Lovelace',
            'totalEarnings' => 1500.0,
            'grossEarnings' => 1400.0,
            'totalPay' => 1200.55,
            'totalEmployerTaxes' => 90.0,
            'totalEmployeeTaxes' => 110.0,
            'totalDeductions' => 50.0,
            'totalReimbursements' => 20.0,
            'totalCourtOrders' => 10.0,
            'totalBenefits' => 5.0,
            'bacsHash' => 'hash-1',
            'paymentMethod' => 'Electronically',
        ]);

        self::assertSame('payslip-1', $payslip->getPayslipID());
        self::assertSame('employee-1', $payslip->getEmployeeID());
        self::assertSame('payrun-1', $payslip->getPayRunID());
        self::assertSame('2026-04-05T00:00:00', $payslip->getLastEdited());
        self::assertSame('Ada', $payslip->getFirstName());
        self::assertSame('Lovelace', $payslip->getLastName());
        self::assertSame(1500.0, $payslip->getTotalEarnings());
        self::assertSame(1400.0, $payslip->getGrossEarnings());
        self::assertSame(1200.55, $payslip->getTotalPay());
        self::assertSame(90.0, $payslip->getTotalEmployerTaxes());
        self::assertSame(110.0, $payslip->getTotalEmployeeTaxes());
        self::assertSame(50.0, $payslip->getTotalDeductions());
        self::assertSame(20.0, $payslip->getTotalReimbursements());
        self::assertSame(10.0, $payslip->getTotalCourtOrders());
        self::assertSame(5.0, $payslip->getTotalBenefits());
        self::assertSame('hash-1', $payslip->getBacsHash());
        self::assertSame('Electronically', $payslip->getPaymentMethod());
    }
}
