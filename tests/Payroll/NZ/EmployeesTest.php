<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\Employee\Employee;
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
            ->using([
                'LeaveTypeID' => 'leave-type-1',
                'ScheduleOfAccrual' => 'ON_ANNIVERSARY_DATE',
            ])
            ->idempotencyKey('leave-setup-key')
            ->save();
        $openingBalances = $employee?->openingBalances()
            ->using([
                'PeriodEndDate' => '2026-03-31',
                'DaysPaid' => 5,
                'GrossEarnings' => 1730.77,
            ])
            ->idempotencyKey('opening-balances-key')
            ->save();
        $employment = $employee?->employment();
        $salaryAndWages = $employee?->salaryAndWages(page: 2);
        $salaryAndWage = $employee?->salaryAndWage('wage-1');
        $createdEmployment = $employee?->createEmployment()
            ->using([
                'StartDate' => '2026-04-01',
                'PayrollCalendarID' => 'calendar-1',
            ])
            ->idempotencyKey('employment-key')
            ->save();
        $createdLeave = $employee?->createLeave()
            ->using([
                'LeaveTypeID' => 'leave-type-1',
                'StartDate' => '2026-04-10',
                'EndDate' => '2026-04-11',
            ])
            ->idempotencyKey('leave-key')
            ->save();
        $createdPaymentMethod = $employee?->createPaymentMethod()
            ->using([
                'BankAccount' => [
                    'AccountNumber' => '98-7654-1234567-00',
                ],
            ])
            ->idempotencyKey('payment-method-key')
            ->save();
        $createdSalaryAndWage = $employee?->createSalaryAndWage()
            ->using([
                'PaymentType' => 'HOURLY',
                'EarningsRateID' => 'earning-rate-1',
            ])
            ->idempotencyKey('salary-key')
            ->save();
        $createdWorkingPattern = $employee?->createWorkingPattern()
            ->using([
                'EffectiveFrom' => '2026-04-01',
            ])
            ->idempotencyKey('working-pattern-key')
            ->save();

        self::assertSame('/payroll.xro/2.0/Employees', $transport->requests()[0]->path);
        self::assertSame('Ada', $transport->requests()[0]->query['filter']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(Employee::class, $employees->first());
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
        self::assertSame('employee-1', $employee?->id);
        self::assertSame('employee-2', $created->id);
        self::assertSame('employee-2', $updated->id);
        self::assertSame('Annual Leave', $leaveTypes?->first()?->name);
        self::assertSame('2026-01-01', $leavePeriods['LeavePeriods'][0]['StartDate']);
        self::assertEquals(24.5, $leaveBalances['LeaveBalances'][0]['Balance']);
        self::assertSame('leave-1', $leaves['Leave'][0]['LeaveID']);
        self::assertSame('leave-1', $leave['Leave']['LeaveID']);
        self::assertSame('12-1234-1234567-00', $paymentMethod['PaymentMethod']['BankAccountNumber']);
        self::assertSame('M', $tax['Tax']['TaxCode']);
        self::assertSame('pattern-1', $workingPatterns['WorkingPatterns'][0]['EmployeeWorkingPatternID']);
        self::assertSame('pattern-1', $workingPattern['WorkingPattern']['EmployeeWorkingPatternID']);
        self::assertSame('employee-1', $leaveSetup['EmployeeLeaveSetup']['EmployeeID']);
        self::assertSame('2026-03-31', $openingBalances['EmployeeOpeningBalances'][0]['PeriodEndDate']);
        self::assertSame('2020-01-15', $employment['Employment']['StartDate']);
        self::assertSame('wage-1', $salaryAndWages['SalaryAndWages'][0]['SalaryAndWagesID']);
        self::assertSame('wage-1', $salaryAndWage['SalaryAndWages']['SalaryAndWagesID']);
        self::assertSame('2026-04-01', $createdEmployment['Employment']['StartDate']);
        self::assertSame('leave-2', $createdLeave['EmployeeLeave']['LeaveID']);
        self::assertSame('98-7654-1234567-00', $createdPaymentMethod['PaymentMethod']['BankAccountNumber']);
        self::assertSame('wage-2', $createdSalaryAndWage['SalaryAndWages']['SalaryAndWagesID']);
        self::assertSame('pattern-2', $createdWorkingPattern['WorkingPattern']['EmployeeWorkingPatternID']);
    }
}
