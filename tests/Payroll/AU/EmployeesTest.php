<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\Employee;
use Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class EmployeesTest extends TestCase
{
    public function test_it_can_query_find_create_and_update_payroll_au_employees(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Jane',
                'LastName' => 'Smith',
                'EmailAddress' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Jane',
                'LastName' => 'Smith',
                'EmailAddress' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'EmailAddress' => 'grace@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'EmailAddress' => 'grace@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employees = $client->payroll()
            ->au()
            ->employees()
            ->where('Status=="ACTIVE"')
            ->orderBy('LastName ASC')
            ->page(2)
            ->get();
        $employee = $client->payroll()->au()->employees()->find('employee-1');
        $created = $client->payroll()->au()->employees()->create()
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();
        $updated = $client->payroll()->au()->employees()->update('employee-2')
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();

        self::assertSame('/payroll.xro/1.0/Employees', $transport->requests()[0]->path);
        self::assertSame('Status=="ACTIVE"', $transport->requests()[0]->query['where']);
        self::assertSame('LastName ASC', $transport->requests()[0]->query['order']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        $firstEmp = $employees->first();
        self::assertNotNull($firstEmp);
        self::assertSame('/payroll.xro/1.0/Employees/employee-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/Employees', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/1.0/Employees/employee-2', $transport->requests()[3]->path);
        self::assertSame('Jane', $firstEmp->getFirstName());
        self::assertSame('employee-1', $employee?->getEmployeeID());
        self::assertSame('employee-2', $created->getEmployeeID());
        self::assertSame('employee-2', $updated->getEmployeeID());
    }

    public function test_it_can_load_payroll_au_employee_leave_balances(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Jane',
                'LastName' => 'Smith',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveBalances' => [[
                'LeaveName' => 'Annual Leave',
                'Balance' => 18.25,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => [
                'LeaveApplicationID' => 'leave-1',
                'EmployeeID' => 'employee-1',
                'Title' => 'Annual Leave',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employee = $client->payroll()->au()->employees()->find('employee-1');
        $leaveBalances = $employee?->leaveBalances();
        $leaveApplication = $employee?->createLeaveApplication()
            ->leaveType('leave-type-1')
            ->title('Annual Leave')
            ->startDate('2026-04-01')
            ->endDate('2026-04-02')
            ->save();

        self::assertSame('/payroll.xro/1.0/Employees/employee-1', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/1.0/Employees/employee-1/LeaveBalances', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/LeaveApplications', $transport->requests()[2]->path);
        $lb = Json::extractFirst($leaveBalances ?? [], 'LeaveBalances');
        self::assertNotNull($lb);
        self::assertEquals(18.25, $lb['Balance']);
        self::assertNotNull($leaveApplication);
        self::assertSame('employee-1', $leaveApplication->getEmployeeID());
    }

    public function test_it_can_paginate_payroll_au_employees(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Employees' => [],
            ], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->employees()
            ->paginate(page: 3, perPage: 50);

        $request = $transport->requests()[0];

        self::assertSame(3, $request->query['page']);
        self::assertSame(50, $request->query['pageSize']);
        self::assertSame(3, $page->page);
        self::assertSame(50, $page->perPage);
    }

    public function test_it_filters_employees_modified_since(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['Employees' => []], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->employees()
            ->modifiedSince(new DateTimeImmutable('2026-03-25T00:00:00+00:00'))
            ->get();

        self::assertSame('2026-03-25T00:00:00+00:00', $transport->requests()[0]->query['If-Modified-Since']);
    }

    public function test_loaded_employee_exposes_getters_and_can_be_saved(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Jane',
                'LastName' => 'Smith',
                'EmailAddress' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Janet',
                'LastName' => 'Smithson',
                'EmailAddress' => 'janet@example.test',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employee = $client->payroll()->au()->employees()->find('employee-1');
        self::assertNotNull($employee);
        self::assertSame('Smith', $employee->getLastName());
        self::assertSame('jane@example.test', $employee->getEmailAddress());
        self::assertSame('ACTIVE', $employee->getStatus());

        $saved = $employee
            ->setFirstName('Janet')
            ->setLastName('Smithson')
            ->setEmailAddress('janet@example.test')
            ->save();

        self::assertSame('/payroll.xro/1.0/Employees/employee-1', $transport->requests()[1]->path);
        self::assertSame('employee-1', $saved->getEmployeeID());
    }

    public function test_create_sends_date_of_birth_and_idempotency_key_and_handles_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $employee = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->employees()
            ->create()
            ->firstName('Grace')
            ->lastName('Hopper')
            ->dateOfBirth('1990-01-15')
            ->idempotencyKey('key-123')
            ->save();

        self::assertSame('key-123', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame([
            'Employee' => [
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'DateOfBirth' => '1990-01-15',
            ],
        ], $transport->requests()[0]->json);
        self::assertNull($employee->getEmployeeID());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Employee())->save();
    }

    public function test_leave_balances_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Employee())->leaveBalances();
    }

    public function test_create_leave_application_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Employee())->createLeaveApplication();
    }
}
