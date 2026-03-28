<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\Employee\Employee;
use Sujip\Xero\Payroll\UK\Employee\LeaveType;
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
        self::assertInstanceOf(Employee::class, $employees->first());
        self::assertSame('Ada', $employees->first()->getFirstName());
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
        self::assertSame('Holiday', $leaveBalances['LeaveBalances'][0]['Name']);
        self::assertEquals(2.0, $statutoryLeaveBalance['StatutoryLeaveBalance']['Balance']);
        self::assertSame('leave-1', $leaves['Leave'][0]['LeaveID']);
        self::assertSame('leave-1', $leave['Leave']['LeaveID']);
        self::assertSame('Main bank account', $paymentMethod['PaymentMethod']['Name']);
        self::assertSame('2020-01-15', $employment['Employment']['StartDate']);
        self::assertInstanceOf(LeaveType::class, $leaveTypes->first());
        self::assertSame('leave-type-1', $leaveTypes->first()->getLeaveTypeID());
        self::assertSame('leave-2', $createdLeave['EmployeeLeave']['LeaveID']);
        self::assertSame('leave-type-2', $createdLeaveType['EmployeeLeaveType']['LeaveTypeID']);
    }
}
