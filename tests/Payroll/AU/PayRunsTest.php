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
use Sujip\Xero\Payroll\AU\PayRun\PayslipSummary;
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

    public function test_it_can_load_embedded_payrun_payslip_summaries_and_a_single_payslip(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'PayRun' => [
                'PayRunID' => 'payrun-1',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'POSTED',
                'Payslips' => [[
                    'PayslipID' => 'payslip-1',
                    'EmployeeID' => 'employee-1',
                    'FirstName' => 'Jane',
                    'LastName' => 'Smith',
                    'NetPay' => '1200.55',
                ]],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Payslip' => [
                'PayslipID' => 'payslip-1',
                'EmployeeID' => 'employee-1',
                'NetPay' => '1200.55',
                'EarningsLines' => [['EarningsRateID' => 'rate-1', 'Amount' => 1200.55]],
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $payRun = $client->payroll()->au()->payRuns()->find('payrun-1');
        $payslipSummaries = $payRun?->payslips();
        $payslip = $client->payroll()->au()->payRuns()->payslip('payslip-1');

        self::assertSame('/payroll.xro/1.0/PayRuns/payrun-1', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/1.0/Payslip/payslip-1', $transport->requests()[1]->path);
        $summary = $payslipSummaries?->first();

        self::assertInstanceOf(PayslipSummary::class, $summary);
        self::assertSame('payslip-1', $summary->getPayslipID());
        self::assertSame('Jane', $summary->getFirstName());
        self::assertInstanceOf(Payslip::class, $payslip);
        self::assertSame('payslip-1', $payslip->getPayslipID());
        self::assertSame([['EarningsRateID' => 'rate-1', 'Amount' => 1200.55]], $payslip->getEarningsLines());
    }

    public function test_it_returns_null_when_payslip_not_found(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        self::assertNull($client->payroll()->au()->payRuns()->payslip('missing'));
    }

    public function test_it_exposes_scopes(): void
    {
        $payRuns = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payRuns();

        $scopes = $payRuns->scopes();

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
            'PayRunPeriodStartDate' => '/Date(1572912000000+0000)/',
            'PayRunPeriodEndDate' => '/Date(1573516800000+0000)/',
            'PayRunStatus' => 'POSTED',
            'PaymentDate' => '/Date(1573430400000+0000)/',
            'PayslipMessage' => 'Thanks for being awesome',
            'UpdatedDateUTC' => '/Date(1583967733054+0000)/',
            'Wages' => 1060.5,
            'Deductions' => 0.0,
            'Tax' => 198.0,
            'Super' => 75.6,
            'Reimbursement' => 0.0,
            'NetPay' => 862.5,
            'ValidationErrors' => [['Message' => 'Invalid pay run']],
        ]);

        self::assertSame('payrun-1', $payRun->getPayRunID());
        self::assertSame('calendar-1', $payRun->getPayrollCalendarID());
        self::assertSame('/Date(1572912000000+0000)/', $payRun->getPayRunPeriodStartDate());
        self::assertSame('/Date(1573516800000+0000)/', $payRun->getPayRunPeriodEndDate());
        self::assertSame('POSTED', $payRun->getPayRunStatus());
        self::assertSame('/Date(1573430400000+0000)/', $payRun->getPaymentDate());
        self::assertSame('Thanks for being awesome', $payRun->getPayslipMessage());
        self::assertSame('/Date(1583967733054+0000)/', $payRun->getUpdatedDateUTC());
        self::assertSame(1060.5, $payRun->getWages());
        self::assertSame(0.0, $payRun->getDeductions());
        self::assertSame(198.0, $payRun->getTax());
        self::assertSame(75.6, $payRun->getSuper());
        self::assertSame(0.0, $payRun->getReimbursement());
        self::assertSame(862.5, $payRun->getNetPay());
        self::assertCount(1, $payRun->getValidationErrors());
        self::assertSame('Invalid pay run', $payRun->getValidationErrors()[0]->getMessage());
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

    public function test_pay_run_payslips_default_to_empty_collection(): void
    {
        self::assertSame(0, (new PayRun())->payslips()->count());
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
            'FirstName' => 'Jane',
            'LastName' => 'Smith',
            'Wages' => 1000.00,
            'Deductions' => 10.00,
            'Tax' => 100.00,
            'Super' => 120.00,
            'Reimbursements' => 5.00,
            'NetPay' => 1200.55,
            'UpdatedDateUTC' => '/Date(1573430400000+0000)/',
            'EarningsLines' => [['EarningsRateID' => 'rate-1', 'Amount' => 1200.55]],
            'LeaveEarningsLines' => [['LeaveTypeID' => 'leave-1', 'Amount' => 0]],
            'TimesheetEarningsLines' => [['EarningsRateID' => 'rate-2', 'Amount' => 50]],
            'DeductionLines' => [['DeductionTypeID' => 'deduction-1', 'Amount' => 10]],
            'LeaveAccrualLines' => [['LeaveTypeID' => 'leave-1', 'NumberOfUnits' => 0.5]],
            'ReimbursementLines' => [['ReimbursementTypeID' => 'reimbursement-1', 'Amount' => 5]],
            'SuperannuationLines' => [['SuperannuationTypeID' => 'super-1', 'Amount' => 120]],
            'TaxLines' => [['TaxType' => 'PAYG', 'Amount' => 100]],
        ]);

        self::assertSame('payslip-1', $payslip->getPayslipID());
        self::assertSame('employee-1', $payslip->getEmployeeID());
        self::assertSame('Jane', $payslip->getFirstName());
        self::assertSame('Smith', $payslip->getLastName());
        self::assertSame(1000.00, $payslip->getWages());
        self::assertSame(10.00, $payslip->getDeductions());
        self::assertSame(100.00, $payslip->getTax());
        self::assertSame(120.00, $payslip->getSuper());
        self::assertSame(5.00, $payslip->getReimbursements());
        self::assertSame(1200.55, $payslip->getNetPay());
        self::assertSame('/Date(1573430400000+0000)/', $payslip->getUpdatedDateUTC());
        self::assertSame([['EarningsRateID' => 'rate-1', 'Amount' => 1200.55]], $payslip->getEarningsLines());
        self::assertSame([['LeaveTypeID' => 'leave-1', 'Amount' => 0]], $payslip->getLeaveEarningsLines());
        self::assertSame([['EarningsRateID' => 'rate-2', 'Amount' => 50]], $payslip->getTimesheetEarningsLines());
        self::assertSame([['DeductionTypeID' => 'deduction-1', 'Amount' => 10]], $payslip->getDeductionLines());
        self::assertSame([['LeaveTypeID' => 'leave-1', 'NumberOfUnits' => 0.5]], $payslip->getLeaveAccrualLines());
        self::assertSame([['ReimbursementTypeID' => 'reimbursement-1', 'Amount' => 5]], $payslip->getReimbursementLines());
        self::assertSame([['SuperannuationTypeID' => 'super-1', 'Amount' => 120]], $payslip->getSuperannuationLines());
        self::assertSame([['TaxType' => 'PAYG', 'Amount' => 100]], $payslip->getTaxLines());
    }

    public function test_payslip_summary_exposes_all_fields(): void
    {
        $summary = (new PayslipSummary())->fill([
            'EmployeeID' => 'employee-1',
            'PayslipID' => 'payslip-1',
            'FirstName' => 'Jane',
            'LastName' => 'Smith',
            'EmployeeGroup' => 'Marketing',
            'Wages' => 1000.00,
            'Deductions' => 10.00,
            'Tax' => 100.00,
            'Super' => 120.00,
            'Reimbursements' => 5.00,
            'NetPay' => 1200.55,
            'UpdatedDateUTC' => '/Date(1573430400000+0000)/',
        ]);

        self::assertSame('employee-1', $summary->getEmployeeID());
        self::assertSame('payslip-1', $summary->getPayslipID());
        self::assertSame('Jane', $summary->getFirstName());
        self::assertSame('Smith', $summary->getLastName());
        self::assertSame('Marketing', $summary->getEmployeeGroup());
        self::assertSame(1000.00, $summary->getWages());
        self::assertSame(10.00, $summary->getDeductions());
        self::assertSame(100.00, $summary->getTax());
        self::assertSame(120.00, $summary->getSuper());
        self::assertSame(5.00, $summary->getReimbursements());
        self::assertSame(1200.55, $summary->getNetPay());
        self::assertSame('/Date(1573430400000+0000)/', $summary->getUpdatedDateUTC());
    }
}
