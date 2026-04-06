<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
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
            'PayRuns' => [[
                'PayRunID' => 'payrun-1',
                'PayrollCalendarID' => 'calendar-1',
                'PayRunStatus' => 'DRAFT',
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

        $runs = $client->payroll()->uk()->payRuns()->status('draft')->page(2)->get();
        $run = $client->payroll()->uk()->payRuns()->find('payrun-1');
        $created = $client->payroll()->uk()->payRuns()->create()->payrollCalendar('calendar-1')->save();

        self::assertSame('/payroll.xro/2.0/PayRuns', $transport->requests()[0]->path);
        self::assertSame('DRAFT', $transport->requests()[0]->query['status']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(PayRun::class, $runs->first());
        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/PayRuns', $transport->requests()[2]->path);
        self::assertSame('payrun-1', $run?->getPayRunID());
        self::assertSame('payrun-2', $created->getPayRunID());
        $firstRun = $runs->first();
        self::assertInstanceOf(PayRun::class, $firstRun);
        self::assertSame('2026-03-01', $firstRun->getPeriodStartDate());
        self::assertSame(1500.25, $firstRun->getTotalCost());
        self::assertSame('Scheduled', $firstRun->getPayRunType());
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

        $payRun = $client->payroll()->uk()->payRuns()->find('payrun-1');
        $payslips = $client->payroll()->uk()->payRuns()->payslips('payrun-1')->get();
        $payslip = $client->payroll()->uk()->payRuns()->payslips('payrun-1')->find('payslip-1');
        $modelPayslips = $payRun?->payslips();

        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1/Payslips', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1/Payslips/payslip-1', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/2.0/PayRuns/payrun-1/Payslips', $transport->requests()[3]->path);
        self::assertInstanceOf(Payslip::class, $payslips->first());
        self::assertSame('payslip-1', $payslip?->getPayslipID());
        self::assertSame('payslip-1', $modelPayslips?->first()?->getPayslipID());
    }
}
