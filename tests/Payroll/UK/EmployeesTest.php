<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\Employee\Employee;
use Sujip\Xero\Payroll\UK\Employee\LeaveType;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class EmployeesTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_load_employee_helpers_for_employees(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Ada',
                'LastName' => 'Lovelace',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Ada',
                'LastName' => 'Lovelace',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveBalances' => [[
                'Name' => 'Holiday',
                'Balance' => 8.5,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'StatutoryLeaveBalance' => [
                'Balance' => 2.0,
                'Units' => 'DAYS',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Leave' => [[
                'LeaveID' => 'leave-1',
                'Status' => 'APPROVED',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Leave' => [
                'LeaveID' => 'leave-1',
                'Status' => 'APPROVED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PaymentMethod' => [
                'Name' => 'Main bank account',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employment' => [
                'StartDate' => '2020-01-15',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveTypes' => [[
                'LeaveTypeID' => 'leave-type-1',
                'Name' => 'Holiday',
                'IsActive' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeave' => [
                'LeaveID' => 'leave-2',
                'Status' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeaveType' => [
                'LeaveTypeID' => 'leave-type-2',
                'OpeningBalance' => 12.5,
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employees = $client->payroll()->uk()->employees()->filter('Ada')->page(2)->get();
        $employee = $client->payroll()->uk()->employees()->find('employee-1');
        $created = $client->payroll()->uk()->employees()->create()
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();
        $updated = $client->payroll()->uk()->employees()->update('employee-2')
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();
        $leaveBalances = $employee?->leaveBalances();
        $statutoryLeaveBalance = $employee?->statutoryLeaveBalance('sick', '2026-03-27');
        $leaves = $employee?->leaves();
        $leave = $employee?->leave('leave-1');
        $paymentMethod = $employee?->paymentMethod();
        $employment = $employee?->employment();
        $leaveTypes = $employee?->leaveTypes();
        $createdLeave = $employee?->createLeave()
            ->leaveType('leave-type-1')
            ->startDate('2026-04-01')
            ->endDate('2026-04-03')
            ->title('Holiday')
            ->save();
        $createdLeaveType = $employee?->createLeaveType()
            ->leaveType('leave-type-2')
            ->scheduleOfAccrual('OnAnniversaryDate')
            ->openingBalance(12.5)
            ->save();

        self::assertSame('/payroll.xro/2.0/Employees', $transport->requests()[0]->path);
        self::assertSame('Ada', $transport->requests()[0]->query['filter']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        $firstEmp = $employees->first();
        self::assertNotNull($firstEmp);
        self::assertSame('Ada', $firstEmp->getFirstName());
        self::assertSame('/payroll.xro/2.0/Employees/employee-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/Employees', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-2', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveBalances', $transport->requests()[4]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/StatutoryLeaveBalance', $transport->requests()[5]->path);
        self::assertSame('sick', $transport->requests()[5]->query['LeaveType']);
        self::assertSame('2026-03-27', $transport->requests()[5]->query['AsOfDate']);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave', $transport->requests()[6]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave/leave-1', $transport->requests()[7]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PaymentMethod', $transport->requests()[8]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Employment', $transport->requests()[9]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveTypes', $transport->requests()[10]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave', $transport->requests()[11]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveTypes', $transport->requests()[12]->path);
        self::assertSame('employee-2', $created->getEmployeeID());
        self::assertSame('employee-2', $updated->getEmployeeID());
        self::assertSame('Holiday', (Json::extractList($leaveBalances ?? [], 'LeaveBalances')[0] ?? [])['Name'] ?? null);
        self::assertEquals(2.0, Json::extractObject($statutoryLeaveBalance ?? [], 'StatutoryLeaveBalance')['Balance'] ?? null);
        self::assertSame('leave-1', (Json::extractList($leaves ?? [], 'Leave')[0] ?? [])['LeaveID'] ?? null);
        self::assertSame('leave-1', Json::extractObject($leave ?? [], 'Leave')['LeaveID'] ?? null);
        self::assertSame('Main bank account', Json::extractObject($paymentMethod ?? [], 'PaymentMethod')['Name'] ?? null);
        self::assertSame('2020-01-15', Json::extractObject($employment ?? [], 'Employment')['StartDate'] ?? null);
        self::assertNotNull($leaveTypes);
        $firstLt = $leaveTypes->first();
        self::assertNotNull($firstLt);
        self::assertSame('leave-type-1', $firstLt->getLeaveTypeID());
        self::assertSame('leave-2', Json::extractObject($createdLeave ?? [], 'EmployeeLeave')['LeaveID'] ?? null);
        self::assertSame('leave-type-2', Json::extractObject($createdLeaveType ?? [], 'EmployeeLeaveType')['LeaveTypeID'] ?? null);
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->employees()
            ->scopes();

        self::assertSame(['payroll.employees'], $scopes->broad);
        self::assertSame(['payroll.employees.read', 'payroll.employees'], $scopes->granular);
    }

    public function test_it_can_paginate_employees(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['Employees' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->employees()
            ->paginate(page: 3, perPage: 50);

        self::assertSame(3, $transport->requests()[0]->query['page']);
        self::assertSame(50, $transport->requests()[0]->query['pageSize']);
        self::assertSame(3, $page->page);
        self::assertSame(50, $page->perPage);
    }

    public function test_employee_exposes_all_fields(): void
    {
        $employee = (new Employee())->fill([
            'EmployeeID' => 'employee-1',
            'FirstName' => 'Ada',
            'LastName' => 'Lovelace',
            'EmailAddress' => 'ada@example.test',
            'Status' => 'ACTIVE',
        ]);

        self::assertSame('employee-1', $employee->getEmployeeID());
        self::assertSame('Ada', $employee->getFirstName());
        self::assertSame('Lovelace', $employee->getLastName());
        self::assertSame('ada@example.test', $employee->getEmailAddress());
        self::assertSame('ACTIVE', $employee->getStatus());
    }

    public function test_it_can_save_a_found_employee(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Ada',
                'LastName' => 'Lovelace',
                'EmailAddress' => 'ada@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Ada',
                'LastName' => 'King',
                'EmailAddress' => 'ada@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employee = $client->payroll()->uk()->employees()->find('employee-1');
        $saved = $employee?->setLastName('King')->save();

        self::assertSame('POST', $transport->requests()[1]->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1', $transport->requests()[1]->path);
        self::assertSame([
            'Employee' => [
                'FirstName' => 'Ada',
                'LastName' => 'King',
                'EmailAddress' => 'ada@example.test',
                'EmployeeID' => 'employee-1',
            ],
        ], $transport->requests()[1]->json);
        self::assertSame('King', $saved?->getLastName());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->save();
    }

    public function test_create_sends_date_of_birth_and_idempotency_key_and_handles_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $employee = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->employees()
            ->create()
            ->firstName('Ada')
            ->lastName('Lovelace')
            ->dateOfBirth('1990-01-15')
            ->idempotencyKey('key-123')
            ->save();

        self::assertSame('key-123', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame([
            'Employee' => [
                'FirstName' => 'Ada',
                'LastName' => 'Lovelace',
                'DateOfBirth' => '1990-01-15',
            ],
        ], $transport->requests()[0]->json);
        self::assertNull($employee->getEmployeeID());
    }

    public function test_leave_type_exposes_all_fields(): void
    {
        $leaveType = (new LeaveType())->fill([
            'LeaveTypeID' => 'leave-type-1',
            'Name' => 'Holiday',
            'IsActive' => true,
        ]);

        self::assertSame('leave-type-1', $leaveType->getLeaveTypeID());
        self::assertSame('Holiday', $leaveType->getName());
        self::assertTrue($leaveType->getIsActive());
    }

    public function test_leave_payloads_send_idempotency_keys(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeave' => ['LeaveID' => 'leave-1'],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeaveType' => ['LeaveTypeID' => 'leave-type-1'],
        ], JSON_THROW_ON_ERROR)));

        $employees = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->employees();

        $employees->createLeave('employee-1')
            ->leaveType('leave-type-1')
            ->startDate('2026-04-01')
            ->endDate('2026-04-03')
            ->idempotencyKey('leave-key')
            ->save();
        $employees->createLeaveType('employee-1')
            ->leaveType('leave-type-1')
            ->idempotencyKey('leave-type-key')
            ->save();

        self::assertSame('leave-key', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame('leave-type-key', $transport->requests()[1]->headers['Idempotency-Key']);
    }
}
