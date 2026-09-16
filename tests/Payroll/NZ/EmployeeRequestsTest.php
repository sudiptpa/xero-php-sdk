<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class EmployeeRequestsTest extends TestCase
{
    public function test_it_sends_tax_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $body = ['taxCode' => 'M', 'isEligibleForKiwiSaver' => false, 'hasStudentLoanBalance' => false, 'studentLoanBalance' => 0];
        $result = $employees->updateTax('employee-1', $body, 'request-1');

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Tax', $request->path);
        self::assertSame($body, $request->json);
        self::assertSame([], $request->query);
        self::assertSame('request-1', $request->headers['Idempotency-Key']);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_leave_type_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $body = ['leaveTypeID' => 'leave-type-1', 'openingBalance' => 0, 'includeHolidayPayEveryPay' => false];
        $result = $employees->createLeaveType('employee-1', $body, 'request-1');

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveTypes', $request->path);
        self::assertSame($body, $request->json);
        self::assertSame([], $request->query);
        self::assertSame('request-1', $request->headers['Idempotency-Key']);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_opening_balances_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $result = $employees->getOpeningBalances('employee-1');

        $request = $transport->requests()[0];
        self::assertSame('GET', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/OpeningBalances', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame([], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_delete_pattern_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $result = $employees->deleteWorkingPattern('employee-1', 'pattern-1');

        $request = $transport->requests()[0];
        self::assertSame('DELETE', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Working-Patterns/pattern-1', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame([], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_update_leave_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $body = ['leaveTypeID' => 'leave-type-1', 'description' => 'Annual leave', 'startDate' => '2026-09-01', 'endDate' => '2026-09-02', 'periods' => []];
        $result = $employees->updateLeave('employee-1', 'leave-1', $body, 'request-1');

        $request = $transport->requests()[0];
        self::assertSame('PUT', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave/leave-1', $request->path);
        self::assertSame($body, $request->json);
        self::assertSame([], $request->query);
        self::assertSame('request-1', $request->headers['Idempotency-Key']);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_delete_leave_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $result = $employees->deleteLeave('employee-1', 'leave-1');

        $request = $transport->requests()[0];
        self::assertSame('DELETE', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave/leave-1', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame([], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_update_salary_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $body = ['earningsRateID' => 'rate-1', 'numberOfUnitsPerWeek' => 0, 'effectiveFrom' => '2026-09-01', 'annualSalary' => 0, 'status' => 'Active', 'paymentType' => 'Salary', 'numberOfUnitsPerDay' => 0];
        $result = $employees->updateSalaryAndWage('employee-1', 'salary-1', $body, 'request-1');

        $request = $transport->requests()[0];
        self::assertSame('PUT', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages/salary-1', $request->path);
        self::assertSame($body, $request->json);
        self::assertSame([], $request->query);
        self::assertSame('request-1', $request->headers['Idempotency-Key']);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_delete_salary_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->nz()->employees();
        $result = $employees->deleteSalaryAndWage('employee-1', 'salary-1');

        $request = $transport->requests()[0];
        self::assertSame('DELETE', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages/salary-1', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame([], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

}
