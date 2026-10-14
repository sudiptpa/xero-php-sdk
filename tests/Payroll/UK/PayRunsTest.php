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
    public function test_it_can_query_and_find_pay_runs(): void
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

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $runs = $client->payroll()->uk()->payRuns()->status('Draft')->page(2)->get();
        $run = $client->payroll()->uk()->payRuns()->find('payrun-1');

        self::assertSame('/payroll.xro/2.0/PayRuns', $transport->requests()[0]->path);
        self::assertSame('Draft', $transport->requests()[0]->query['status']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        $firstRun = $runs->first();
        self::assertNotNull($firstRun);
        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1', $transport->requests()[1]->path);
        self::assertSame('payrun-1', $run?->getPayRunID());
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

    public function test_it_can_page_through_payslips(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode(['paySlips' => []], JSON_THROW_ON_ERROR)));

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->payRuns()
            ->payslips('payrun-1')
            ->get(2);

        self::assertSame('payrun-1', $transport->requests()[0]->query['PayRunID']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
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
        self::assertSame(['payroll.payslip'], $payslipScopes->broad);
        self::assertSame(['payroll.payslip.read', 'payroll.payslip'], $payslipScopes->granular);
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
            'earningsLines' => [[
                'earningsLineID' => 'earnings-line-1',
                'earningsRateID' => 'rate-1',
                'displayName' => 'Regular Hours',
                'ratePerUnit' => 12.5,
                'numberOfUnits' => 8.0,
                'fixedAmount' => 0.0,
                'amount' => 100.0,
                'isLinkedToTimesheet' => false,
                'isAverageDailyPayRate' => false,
            ]],
            'leaveEarningsLines' => [[
                'earningsRateID' => 'leave-rate-1',
                'ratePerUnit' => 12.5,
                'numberOfUnits' => 4.0,
                'fixedAmount' => 0.0,
                'amount' => 50.0,
                'isLinkedToTimesheet' => false,
            ]],
            'timesheetEarningsLines' => [[
                'earningsRateID' => 'timesheet-rate-1',
                'ratePerUnit' => 12.5,
                'numberOfUnits' => 2.0,
                'fixedAmount' => 0.0,
                'amount' => 25.0,
                'isLinkedToTimesheet' => true,
            ]],
            'deductionLines' => [[
                'deductionTypeID' => 'deduction-1',
                'amount' => 10.0,
                'subjectToTax' => true,
                'percentage' => 5.0,
            ]],
            'reimbursementLines' => [[
                'reimbursementTypeID' => 'reimbursement-1',
                'description' => 'Travel expenses',
                'amount' => 20.0,
            ]],
            'leaveAccrualLines' => [['leaveTypeID' => 'leave-2', 'numberOfUnits' => 8.0]],
            'benefitLines' => [[
                'benefitTypeID' => 'benefit-1',
                'displayName' => 'Company Car',
                'amount' => 5.0,
                'fixedAmount' => 5.0,
                'percentage' => 0.0,
            ]],
            'paymentLines' => [[
                'paymentLineID' => 'payment-1',
                'amount' => 1200.55,
                'accountNumber' => '12345678',
                'sortCode' => '111111',
                'accountName' => 'Ada Lovelace',
            ]],
            'employeeTaxLines' => [[
                'taxLineID' => 'tax-1',
                'description' => 'Income Tax',
                'isEmployerTax' => false,
                'amount' => 110.0,
                'globalTaxTypeID' => 'global-tax-1',
                'manualAdjustment' => false,
            ]],
            'employerTaxLines' => [[
                'taxLineID' => 'tax-2',
                'description' => 'Employer NIC',
                'isEmployerTax' => true,
                'amount' => 90.0,
                'globalTaxTypeID' => 'global-tax-2',
                'manualAdjustment' => true,
            ]],
            'courtOrderLines' => [['courtOrderTypeID' => 'court-1', 'amount' => 10.0]],
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
        $earningsLine = $payslip->getEarningsLines()[0];
        self::assertSame('earnings-line-1', $earningsLine->getEarningsLineID());
        self::assertSame('rate-1', $earningsLine->getEarningsRateID());
        self::assertSame('Regular Hours', $earningsLine->getDisplayName());
        self::assertSame(12.5, $earningsLine->getRatePerUnit());
        self::assertSame(8.0, $earningsLine->getNumberOfUnits());
        self::assertSame(0.0, $earningsLine->getFixedAmount());
        self::assertSame(100.0, $earningsLine->getAmount());
        self::assertFalse($earningsLine->getIsLinkedToTimesheet());
        self::assertFalse($earningsLine->getIsAverageDailyPayRate());

        $leaveEarningsLine = $payslip->getLeaveEarningsLines()[0];
        self::assertSame('leave-rate-1', $leaveEarningsLine->getEarningsRateID());
        self::assertSame(12.5, $leaveEarningsLine->getRatePerUnit());
        self::assertSame(4.0, $leaveEarningsLine->getNumberOfUnits());
        self::assertSame(0.0, $leaveEarningsLine->getFixedAmount());
        self::assertSame(50.0, $leaveEarningsLine->getAmount());
        self::assertFalse($leaveEarningsLine->getIsLinkedToTimesheet());

        $timesheetEarningsLine = $payslip->getTimesheetEarningsLines()[0];
        self::assertSame('timesheet-rate-1', $timesheetEarningsLine->getEarningsRateID());
        self::assertSame(12.5, $timesheetEarningsLine->getRatePerUnit());
        self::assertSame(2.0, $timesheetEarningsLine->getNumberOfUnits());
        self::assertSame(0.0, $timesheetEarningsLine->getFixedAmount());
        self::assertSame(25.0, $timesheetEarningsLine->getAmount());
        self::assertTrue($timesheetEarningsLine->getIsLinkedToTimesheet());

        $deductionLine = $payslip->getDeductionLines()[0];
        self::assertSame('deduction-1', $deductionLine->getDeductionTypeID());
        self::assertSame(10.0, $deductionLine->getAmount());
        self::assertTrue($deductionLine->getSubjectToTax());
        self::assertSame(5.0, $deductionLine->getPercentage());

        $reimbursementLine = $payslip->getReimbursementLines()[0];
        self::assertSame('reimbursement-1', $reimbursementLine->getReimbursementTypeID());
        self::assertSame('Travel expenses', $reimbursementLine->getDescription());
        self::assertSame(20.0, $reimbursementLine->getAmount());

        self::assertSame('leave-2', $payslip->getLeaveAccrualLines()[0]->getLeaveTypeID());
        self::assertSame(8.0, $payslip->getLeaveAccrualLines()[0]->getNumberOfUnits());

        $benefitLine = $payslip->getBenefitLines()[0];
        self::assertSame('benefit-1', $benefitLine->getBenefitTypeID());
        self::assertSame('Company Car', $benefitLine->getDisplayName());
        self::assertSame(5.0, $benefitLine->getAmount());
        self::assertSame(5.0, $benefitLine->getFixedAmount());
        self::assertSame(0.0, $benefitLine->getPercentage());

        $paymentLine = $payslip->getPaymentLines()[0];
        self::assertSame('payment-1', $paymentLine->getPaymentLineID());
        self::assertSame(1200.55, $paymentLine->getAmount());
        self::assertSame('12345678', $paymentLine->getAccountNumber());
        self::assertSame('111111', $paymentLine->getSortCode());
        self::assertSame('Ada Lovelace', $paymentLine->getAccountName());

        $employeeTaxLine = $payslip->getEmployeeTaxLines()[0];
        self::assertSame('tax-1', $employeeTaxLine->getTaxLineID());
        self::assertSame('Income Tax', $employeeTaxLine->getDescription());
        self::assertFalse($employeeTaxLine->getIsEmployerTax());
        self::assertSame(110.0, $employeeTaxLine->getAmount());
        self::assertSame('global-tax-1', $employeeTaxLine->getGlobalTaxTypeID());
        self::assertFalse($employeeTaxLine->getManualAdjustment());

        $employerTaxLine = $payslip->getEmployerTaxLines()[0];
        self::assertSame('tax-2', $employerTaxLine->getTaxLineID());
        self::assertSame('Employer NIC', $employerTaxLine->getDescription());
        self::assertTrue($employerTaxLine->getIsEmployerTax());
        self::assertSame(90.0, $employerTaxLine->getAmount());
        self::assertSame('global-tax-2', $employerTaxLine->getGlobalTaxTypeID());
        self::assertTrue($employerTaxLine->getManualAdjustment());

        self::assertSame('court-1', $payslip->getCourtOrderLines()[0]->getCourtOrderTypeID());
        self::assertSame(10.0, $payslip->getCourtOrderLines()[0]->getAmount());
    }
}
