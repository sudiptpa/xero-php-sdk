<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\Employee\Employee;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class EmployeesTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_load_employee_leave_helpers(): void
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
            'LeaveTypes' => [[
                'LeaveTypeID' => 'leave-type-1',
                'Name' => 'Annual Leave',
                'IsActive' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeavePeriods' => [[
                'StartDate' => '2026-01-01',
                'EndDate' => '2026-03-31',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveBalances' => [[
                'Balance' => 24.5,
            ]],
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
                'BankAccountNumber' => '12-1234-1234567-00',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Tax' => [
                'TaxCode' => 'M',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'WorkingPatterns' => [[
                'EmployeeWorkingPatternID' => 'pattern-1',
                'Description' => 'Standard week',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'WorkingPattern' => [
                'EmployeeWorkingPatternID' => 'pattern-1',
                'Description' => 'Standard week',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeaveSetup' => [
                'EmployeeID' => 'employee-1',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'EmployeeOpeningBalances' => [[
                'PeriodEndDate' => '2026-03-31',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employment' => [
                'StartDate' => '2020-01-15',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'SalaryAndWages' => [[
                'SalaryAndWagesID' => 'wage-1',
                'PaymentType' => 'SALARY',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'SalaryAndWages' => [
                'SalaryAndWagesID' => 'wage-1',
                'PaymentType' => 'SALARY',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employment' => [
                'StartDate' => '2026-04-01',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeave' => [
                'LeaveID' => 'leave-2',
                'Status' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'PaymentMethod' => [
                'BankAccountNumber' => '98-7654-1234567-00',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'SalaryAndWages' => [
                'SalaryAndWagesID' => 'wage-2',
                'PaymentType' => 'HOURLY',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'WorkingPattern' => [
                'EmployeeWorkingPatternID' => 'pattern-2',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employees = $client->payroll()->nz()->employees()->filter('Ada')->page(2)->get();
        $employee = $client->payroll()->nz()->employees()->find('employee-1');
        $created = $client->payroll()->nz()->employees()->create()
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();
        $updated = $client->payroll()->nz()->employees()->update('employee-2')
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();
        $leaveTypes = $employee?->leaveTypes();
        $leavePeriods = $employee?->leavePeriods('2026-01-01', '2026-03-31');
        $leaveBalances = $employee?->leaveBalances();
        $leaves = $employee?->leaves();
        $leave = $employee?->leave('leave-1');
        $paymentMethod = $employee?->paymentMethod();
        $tax = $employee?->tax();
        $workingPatterns = $employee?->workingPatterns();
        $workingPattern = $employee?->workingPattern('pattern-1');
        $leaveSetup = $employee?->leaveSetup()
            ->leaveType('leave-type-1')
            ->scheduleOfAccrual('ON_ANNIVERSARY_DATE')
            ->idempotencyKey('leave-setup-key')
            ->save();
        $openingBalances = $employee?->openingBalances()
            ->periodEndDate('2026-03-31')
            ->daysPaid(5)
            ->grossEarnings(1730.77)
            ->idempotencyKey('opening-balances-key')
            ->save();
        $employment = $employee?->employment();
        $salaryAndWages = $employee?->salaryAndWages(page: 2);
        $salaryAndWage = $employee?->salaryAndWage('wage-1');
        $createdEmployment = $employee?->createEmployment()
            ->startDate('2026-04-01')
            ->payrollCalendar('calendar-1')
            ->idempotencyKey('employment-key')
            ->save();
        $createdLeave = $employee?->createLeave()
            ->leaveType('leave-type-1')
            ->startDate('2026-04-10')
            ->endDate('2026-04-11')
            ->idempotencyKey('leave-key')
            ->save();
        $createdPaymentMethod = $employee?->createPaymentMethod()
            ->bankAccountNumber('98-7654-1234567-00')
            ->idempotencyKey('payment-method-key')
            ->save();
        $createdSalaryAndWage = $employee?->createSalaryAndWage()
            ->paymentType('HOURLY')
            ->earningsRate('earning-rate-1')
            ->idempotencyKey('salary-key')
            ->save();
        $createdWorkingPattern = $employee?->createWorkingPattern()
            ->effectiveFrom('2026-04-01')
            ->idempotencyKey('working-pattern-key')
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
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveTypes', $transport->requests()[4]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeavePeriods', $transport->requests()[5]->path);
        self::assertSame('2026-01-01', $transport->requests()[5]->query['startDate']);
        self::assertSame('2026-03-31', $transport->requests()[5]->query['endDate']);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveBalances', $transport->requests()[6]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave', $transport->requests()[7]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave/leave-1', $transport->requests()[8]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PaymentMethods', $transport->requests()[9]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Tax', $transport->requests()[10]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Working-Patterns', $transport->requests()[11]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Working-Patterns/pattern-1', $transport->requests()[12]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveSetup', $transport->requests()[13]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/OpeningBalances', $transport->requests()[14]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Employment', $transport->requests()[15]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages', $transport->requests()[16]->path);
        self::assertSame(2, $transport->requests()[16]->query['page']);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages/wage-1', $transport->requests()[17]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Employment', $transport->requests()[18]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave', $transport->requests()[19]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PaymentMethods', $transport->requests()[20]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/SalaryAndWages', $transport->requests()[21]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Working-Patterns', $transport->requests()[22]->path);
        self::assertSame('leave-setup-key', $transport->requests()[13]->headers['Idempotency-Key']);
        self::assertSame('opening-balances-key', $transport->requests()[14]->headers['Idempotency-Key']);
        self::assertSame('employment-key', $transport->requests()[18]->headers['Idempotency-Key']);
        self::assertSame('leave-key', $transport->requests()[19]->headers['Idempotency-Key']);
        self::assertSame('payment-method-key', $transport->requests()[20]->headers['Idempotency-Key']);
        self::assertSame('salary-key', $transport->requests()[21]->headers['Idempotency-Key']);
        self::assertSame('working-pattern-key', $transport->requests()[22]->headers['Idempotency-Key']);
        self::assertSame('employee-1', $employee?->getEmployeeID());
        self::assertSame('employee-2', $created->getEmployeeID());
        self::assertSame('employee-2', $updated->getEmployeeID());
        self::assertSame('Annual Leave', $leaveTypes?->first()?->getName());
        self::assertSame('2026-01-01', (Json::extractList($leavePeriods ?? [], 'LeavePeriods')[0] ?? [])['StartDate'] ?? null);
        self::assertEquals(24.5, (Json::extractList($leaveBalances ?? [], 'LeaveBalances')[0] ?? [])['Balance'] ?? null);
        self::assertSame('leave-1', (Json::extractList($leaves ?? [], 'Leave')[0] ?? [])['LeaveID'] ?? null);
        self::assertSame('leave-1', Json::extractObject($leave ?? [], 'Leave')['LeaveID'] ?? null);
        self::assertSame('12-1234-1234567-00', Json::extractObject($paymentMethod ?? [], 'PaymentMethod')['BankAccountNumber'] ?? null);
        self::assertSame('M', Json::extractObject($tax ?? [], 'Tax')['TaxCode'] ?? null);
        self::assertSame('pattern-1', (Json::extractList($workingPatterns ?? [], 'WorkingPatterns')[0] ?? [])['EmployeeWorkingPatternID'] ?? null);
        self::assertSame('pattern-1', Json::extractObject($workingPattern ?? [], 'WorkingPattern')['EmployeeWorkingPatternID'] ?? null);
        self::assertSame('employee-1', Json::extractObject($leaveSetup ?? [], 'EmployeeLeaveSetup')['EmployeeID'] ?? null);
        self::assertSame('2026-03-31', (Json::extractList($openingBalances ?? [], 'EmployeeOpeningBalances')[0] ?? [])['PeriodEndDate'] ?? null);
        self::assertSame('2020-01-15', Json::extractObject($employment ?? [], 'Employment')['StartDate'] ?? null);
        self::assertSame('wage-1', (Json::extractList($salaryAndWages ?? [], 'SalaryAndWages')[0] ?? [])['SalaryAndWagesID'] ?? null);
        self::assertSame('wage-1', Json::extractObject($salaryAndWage ?? [], 'SalaryAndWages')['SalaryAndWagesID'] ?? null);
        self::assertSame('2026-04-01', Json::extractObject($createdEmployment ?? [], 'Employment')['StartDate'] ?? null);
        self::assertSame('leave-2', Json::extractObject($createdLeave ?? [], 'EmployeeLeave')['LeaveID'] ?? null);
        self::assertSame('98-7654-1234567-00', Json::extractObject($createdPaymentMethod ?? [], 'PaymentMethod')['BankAccountNumber'] ?? null);
        self::assertSame('wage-2', Json::extractObject($createdSalaryAndWage ?? [], 'SalaryAndWages')['SalaryAndWagesID'] ?? null);
        self::assertSame('pattern-2', Json::extractObject($createdWorkingPattern ?? [], 'WorkingPattern')['EmployeeWorkingPatternID'] ?? null);
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
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
            ->nz()
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

        $employee = $client->payroll()->nz()->employees()->find('employee-1');
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

    public function test_create_sends_date_of_birth_and_idempotency_key_and_handles_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $employee = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
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

    public function test_leave_payload_sends_title(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'EmployeeLeave' => [
                'LeaveID' => 'leave-1',
                'Title' => 'Annual Leave',
            ],
        ], JSON_THROW_ON_ERROR)));

        $leave = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->employees()
            ->createLeave('employee-1')
            ->leaveType('leave-type-1')
            ->title('Annual Leave')
            ->startDate('2026-04-10')
            ->endDate('2026-04-11')
            ->save();

        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave', $transport->requests()[0]->path);
        self::assertSame([
            'LeaveTypeID' => 'leave-type-1',
            'Title' => 'Annual Leave',
            'StartDate' => '2026-04-10',
            'EndDate' => '2026-04-11',
        ], $transport->requests()[0]->json);
        self::assertSame('Annual Leave', Json::extractObject($leave, 'EmployeeLeave')['Title'] ?? null);
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->save();
    }

    public function test_leave_types_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->leaveTypes();
    }

    public function test_leave_periods_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->leavePeriods('2026-01-01', '2026-03-31');
    }

    public function test_leave_balances_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->leaveBalances();
    }

    public function test_leaves_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->leaves();
    }

    public function test_leave_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->leave('leave-1');
    }

    public function test_payment_method_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->paymentMethod();
    }

    public function test_tax_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->tax();
    }

    public function test_working_patterns_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->workingPatterns();
    }

    public function test_working_pattern_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->workingPattern('pattern-1');
    }
}
