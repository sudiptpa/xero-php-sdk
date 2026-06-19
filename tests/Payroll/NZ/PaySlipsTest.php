<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\PaySlip\PaySlip;
use Sujip\Xero\Xero;

final class PaySlipsTest extends TestCase
{
    public function test_it_lists_payslips_for_a_pay_run(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'paySlips' => [[
                'paySlipID' => 'payslip-1',
                'employeeID' => 'employee-1',
                'payRunID' => 'payrun-1',
                'firstName' => 'Tane',
                'lastName' => 'Mahuta',
                'totalPay' => 1200.55,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $paySlips = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->paySlips()->page(2)->get('payrun-1');

        $request = $transport->requests()[0];
        self::assertSame('/payroll.xro/2.0/PaySlips', $request->path);
        self::assertSame('payrun-1', $request->query['PayRunID']);
        self::assertSame(2, $request->query['page']);

        $first = $paySlips->first();
        self::assertNotNull($first);
        self::assertSame('payslip-1', $first->getPaySlipID());
        self::assertSame('Tane', $first->getFirstName());
        self::assertSame(1200.55, $first->getTotalPay());
    }

    public function test_it_finds_a_payslip_and_hydrates_lines(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'paySlip' => [
                'paySlipID' => 'payslip-1',
                'employeeID' => 'employee-1',
                'payRunID' => 'payrun-1',
                'lastEdited' => '2026-06-01T00:00:00',
                'lastName' => 'Mahuta',
                'totalEarnings' => 2000,
                'grossEarnings' => 2000,
                'totalEmployerTaxes' => 50,
                'totalEmployeeTaxes' => 400,
                'totalDeductions' => 100,
                'totalReimbursements' => 25,
                'totalStatutoryDeductions' => 30,
                'totalSuperannuation' => 60,
                'bacsHash' => 'hash-1',
                'paymentMethod' => 'Electronically',
                'earningsLines' => [[
                    'earningsLineID' => 'line-1',
                    'earningsRateID' => 'rate-1',
                    'displayName' => 'Ordinary Time',
                    'ratePerUnit' => 25,
                    'numberOfUnits' => 80,
                ]],
                'leaveEarningsLines' => [['earningsRateID' => 'rate-2']],
                'timesheetEarningsLines' => [['earningsRateID' => 'rate-3']],
                'deductionLines' => [['deductionTypeID' => 'deduction-1']],
                'reimbursementLines' => [['reimbursementTypeID' => 'reimbursement-1']],
                'leaveAccrualLines' => [['leaveTypeID' => 'leave-1']],
                'superannuationLines' => [['contributionType' => 'KiwiSaver']],
                'paymentLines' => [['amount' => 1200.55]],
                'employeeTaxLines' => [['amount' => 400]],
                'employerTaxLines' => [['amount' => 50]],
                'statutoryDeductionLines' => [['amount' => 30]],
                'taxSettings' => ['period' => 'Weekly'],
                'grossEarningsHistory' => ['daysPaid' => 5],
            ],
        ], JSON_THROW_ON_ERROR)));

        $paySlip = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->paySlips()->find('payslip-1');

        self::assertSame('/payroll.xro/2.0/PaySlips/payslip-1', $transport->requests()[0]->path);
        self::assertNotNull($paySlip);
        self::assertSame('employee-1', $paySlip->getEmployeeID());
        self::assertSame('payrun-1', $paySlip->getPayRunID());
        self::assertSame('2026-06-01T00:00:00', $paySlip->getLastEdited());
        self::assertSame('Mahuta', $paySlip->getLastName());
        self::assertSame(2000.0, $paySlip->getTotalEarnings());
        self::assertSame(2000.0, $paySlip->getGrossEarnings());
        self::assertSame(50.0, $paySlip->getTotalEmployerTaxes());
        self::assertSame(400.0, $paySlip->getTotalEmployeeTaxes());
        self::assertSame(100.0, $paySlip->getTotalDeductions());
        self::assertSame(25.0, $paySlip->getTotalReimbursements());
        self::assertSame(30.0, $paySlip->getTotalStatutoryDeductions());
        self::assertSame(60.0, $paySlip->getTotalSuperannuation());
        self::assertSame('hash-1', $paySlip->getBacsHash());
        self::assertSame('Electronically', $paySlip->getPaymentMethod());
        self::assertCount(1, $paySlip->getEarningsLines());
        self::assertCount(1, $paySlip->getLeaveEarningsLines());
        self::assertCount(1, $paySlip->getTimesheetEarningsLines());
        self::assertCount(1, $paySlip->getDeductionLines());
        self::assertCount(1, $paySlip->getReimbursementLines());
        self::assertCount(1, $paySlip->getLeaveAccrualLines());
        self::assertCount(1, $paySlip->getSuperannuationLines());
        self::assertCount(1, $paySlip->getPaymentLines());
        self::assertCount(1, $paySlip->getEmployeeTaxLines());
        self::assertCount(1, $paySlip->getEmployerTaxLines());
        self::assertCount(1, $paySlip->getStatutoryDeductionLines());
        self::assertSame(['period' => 'Weekly'], $paySlip->getTaxSettings());
        self::assertSame(['daysPaid' => 5], $paySlip->getGrossEarningsHistory());
    }

    public function test_find_returns_null_when_payslip_is_missing(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $paySlip = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->paySlips()->find('missing');

        self::assertNull($paySlip);
    }

    public function test_it_updates_payslip_line_items(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'paySlip' => ['paySlipID' => 'payslip-1', 'totalEarnings' => 2100],
        ], JSON_THROW_ON_ERROR)));

        $updated = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->nz()->paySlips()->updateLineItems(
                'payslip-1',
                (new PaySlip())->setEarningsLines([[
                    'earningsRateID' => 'rate-1',
                    'ratePerUnit' => 26,
                    'numberOfUnits' => 80,
                ]]),
                'payslip-key'
            );

        $request = $transport->requests()[0];
        self::assertSame('PUT', $request->method);
        self::assertSame('/payroll.xro/2.0/PaySlips/payslip-1', $request->path);
        self::assertSame('payslip-key', $request->headers['Idempotency-Key']);
        self::assertSame([
            'earningsLines' => [[
                'earningsRateID' => 'rate-1',
                'ratePerUnit' => 26,
                'numberOfUnits' => 80,
            ]],
        ], $request->json);
        self::assertSame(2100.0, $updated->getTotalEarnings());
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()->nz()->paySlips()->scopes();

        self::assertSame(['payroll.payslip'], $scopes->broad);
        self::assertSame(['payroll.payslip.read', 'payroll.payslip'], $scopes->granular);
    }
}
