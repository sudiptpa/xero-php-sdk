<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class EmployeeRequestsTest extends TestCase
{
    public function test_it_sends_tax_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $result = $employees->tax('employee-1');

        $request = $transport->requests()[0];
        self::assertSame('GET', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Tax', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame([], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_leave_periods_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $result = $employees->leavePeriods('employee-1', '2026-09-01', '2026-09-30');

        $request = $transport->requests()[0];
        self::assertSame('GET', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeavePeriods', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame(['startDate' => '2026-09-01', 'endDate' => '2026-09-30'], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_salary_list_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $result = $employees->salaryAndWages('employee-1', 2);

        $request = $transport->requests()[0];
        self::assertSame('GET', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame(['page' => 2], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_salary_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $result = $employees->salaryAndWage('employee-1', 'salary-1');

        $request = $transport->requests()[0];
        self::assertSame('GET', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages/salary-1', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame([], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_employment_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $body = ['payrollCalendarID' => 'calendar-1', 'startDate' => '2026-09-01', 'employeeNumber' => '42', 'niCategories' => []];
        $result = $employees->createEmployment('employee-1', $body, 'request-1');

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Employment', $request->path);
        self::assertSame($body, $request->json);
        self::assertSame([], $request->query);
        self::assertSame('request-1', $request->headers['Idempotency-Key']);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_payment_method_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $body = ['paymentMethod' => 'Electronically', 'bankAccounts' => []];
        $result = $employees->createPaymentMethod('employee-1', $body, 'request-1');

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PaymentMethods', $request->path);
        self::assertSame($body, $request->json);
        self::assertSame([], $request->query);
        self::assertSame('request-1', $request->headers['Idempotency-Key']);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_create_salary_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $body = ['earningsRateID' => 'rate-1', 'numberOfUnitsPerWeek' => 0, 'effectiveFrom' => '2026-09-01', 'annualSalary' => 0, 'status' => 'Active', 'paymentType' => 'Salary'];
        $result = $employees->createSalaryAndWage('employee-1', $body, 'request-1');

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages', $request->path);
        self::assertSame($body, $request->json);
        self::assertSame([], $request->query);
        self::assertSame('request-1', $request->headers['Idempotency-Key']);
        self::assertSame(['status' => 'ok'], $result);
    }

    public function test_it_sends_update_leave_requests(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"status":"ok"}'));
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
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
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
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
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $body = ['earningsRateID' => 'rate-1', 'numberOfUnitsPerWeek' => 0, 'effectiveFrom' => '2026-09-01', 'annualSalary' => 0, 'status' => 'Active', 'paymentType' => 'Salary'];
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
        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-1')->payroll()->uk()->employees();
        $result = $employees->deleteSalaryAndWage('employee-1', 'salary-1');

        $request = $transport->requests()[0];
        self::assertSame('DELETE', $request->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages/salary-1', $request->path);
        self::assertSame(null, $request->json);
        self::assertSame([], $request->query);
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertTrue($result);
    }

}
