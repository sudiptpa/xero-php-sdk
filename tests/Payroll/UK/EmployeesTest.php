<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\Employee\EarningsTemplate;
use Sujip\Xero\Payroll\UK\Employee\Employee;
use Sujip\Xero\Payroll\UK\Employee\EmployeeLeaveType;
use Sujip\Xero\Payroll\UK\Employee\EmployeeOpeningBalances;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class EmployeesTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_load_employee_helpers_for_employees(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'employees' => [[
                'employeeID' => 'employee-1',
                'firstName' => 'Ada',
                'lastName' => 'Lovelace',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'employee' => [
                'employeeID' => 'employee-1',
                'firstName' => 'Ada',
                'lastName' => 'Lovelace',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'employee' => [
                'employeeID' => 'employee-2',
                'firstName' => 'Grace',
                'lastName' => 'Hopper',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'employee' => [
                'employeeID' => 'employee-2',
                'firstName' => 'Grace',
                'lastName' => 'Hopper',
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
            'paymentMethod' => [
                'Name' => 'Electronically',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'leaveTypes' => [[
                'leaveTypeID' => 'leave-type-1',
                'scheduleOfAccrual' => 'OnAnniversaryDate',
                'openingBalance' => 40,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeave' => [
                'LeaveID' => 'leave-2',
                'Status' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'leaveType' => [
                'leaveTypeID' => 'leave-type-2',
                'openingBalance' => 12.5,
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
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PaymentMethods', $transport->requests()[8]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveTypes', $transport->requests()[9]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/Leave', $transport->requests()[10]->path);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/LeaveTypes', $transport->requests()[11]->path);
        self::assertSame('employee-2', $created->getEmployeeID());
        self::assertSame('employee-2', $updated->getEmployeeID());
        self::assertSame('Holiday', (Json::extractList($leaveBalances ?? [], 'LeaveBalances')[0] ?? [])['Name'] ?? null);
        self::assertEquals(2.0, Json::extractObject($statutoryLeaveBalance ?? [], 'StatutoryLeaveBalance')['Balance'] ?? null);
        self::assertSame('leave-1', (Json::extractList($leaves ?? [], 'Leave')[0] ?? [])['LeaveID'] ?? null);
        self::assertSame('leave-1', Json::extractObject($leave ?? [], 'Leave')['LeaveID'] ?? null);
        self::assertSame('Electronically', Json::extractObject($paymentMethod ?? [], 'paymentMethod')['Name'] ?? null);
        self::assertNotNull($leaveTypes);
        $firstLt = $leaveTypes->first();
        self::assertNotNull($firstLt);
        self::assertSame('leave-type-1', $firstLt->getLeaveTypeID());
        self::assertSame('leave-2', Json::extractObject($createdLeave ?? [], 'EmployeeLeave')['LeaveID'] ?? null);
        self::assertSame('leave-type-2', Json::extractObject($createdLeaveType ?? [], 'leaveType')['leaveTypeID'] ?? null);
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
            new Response(200, body: json_encode(['employees' => []], JSON_THROW_ON_ERROR))
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
            'employeeID' => 'employee-1',
            'title' => 'Mrs',
            'firstName' => 'Ada',
            'lastName' => 'Lovelace',
            'dateOfBirth' => '1990-01-02',
            'email' => 'ada@example.test',
            'gender' => 'F',
            'phoneNumber' => '415-555-1212',
            'startDate' => '2020-01-19',
            'endDate' => '2026-01-19',
            'payrollCalendarID' => 'calendar-1',
            'updatedDateUTC' => '2026-03-29T00:00:00',
            'createdDateUTC' => '2020-01-01T00:00:00',
            'niCategory' => 'A',
            'nationalInsuranceNumber' => 'AB123456C',
            'isOffPayrollWorker' => true,
        ]);

        self::assertSame('employee-1', $employee->getEmployeeID());
        self::assertSame('Mrs', $employee->getTitle());
        self::assertSame('Ada', $employee->getFirstName());
        self::assertSame('Lovelace', $employee->getLastName());
        self::assertSame('1990-01-02', $employee->getDateOfBirth());
        self::assertSame('ada@example.test', $employee->getEmailAddress());
        self::assertSame('F', $employee->getGender());
        self::assertSame('415-555-1212', $employee->getPhoneNumber());
        self::assertSame('2020-01-19', $employee->getStartDate());
        self::assertSame('2026-01-19', $employee->getEndDate());
        self::assertSame('calendar-1', $employee->getPayrollCalendarID());
        self::assertSame('2026-03-29T00:00:00', $employee->getUpdatedDateUTC());
        self::assertSame('2020-01-01T00:00:00', $employee->getCreatedDateUTC());
        self::assertSame('A', $employee->getNiCategory());
        self::assertSame('AB123456C', $employee->getNationalInsuranceNumber());
        self::assertTrue($employee->getIsOffPayrollWorker());
    }

    public function test_it_can_save_a_found_employee(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'employee' => [
                'employeeID' => 'employee-1',
                'firstName' => 'Ada',
                'lastName' => 'Lovelace',
                'email' => 'ada@example.test',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'employee' => [
                'employeeID' => 'employee-1',
                'firstName' => 'Ada',
                'lastName' => 'King',
                'email' => 'ada@example.test',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employee = $client->payroll()->uk()->employees()->find('employee-1');
        $saved = $employee?->setLastName('King')->save();

        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1', $transport->requests()[1]->path);
        self::assertSame([
            'firstName' => 'Ada',
            'lastName' => 'King',
            'email' => 'ada@example.test',
            'employeeID' => 'employee-1',
        ], $transport->requests()[1]->json);
        self::assertSame('King', $saved?->getLastName());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->save();
    }

    public function test_leave_balances_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->leaveBalances();
    }

    public function test_statutory_leave_balance_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->statutoryLeaveBalance();
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

    public function test_leave_types_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->leaveTypes();
    }

    public function test_create_leave_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->createLeave();
    }

    public function test_create_leave_type_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Employee())->createLeaveType();
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
            'firstName' => 'Ada',
            'lastName' => 'Lovelace',
            'dateOfBirth' => '1990-01-15',
        ], $transport->requests()[0]->json);
        self::assertNull($employee->getEmployeeID());
    }

    public function test_leave_type_exposes_all_fields(): void
    {
        $leaveType = (new EmployeeLeaveType())->fill([
            'leaveTypeID' => 'leave-type-1',
            'scheduleOfAccrual' => 'OnAnniversaryDate',
            'hoursAccruedAnnually' => 200,
            'maximumToAccrue' => 80,
            'openingBalance' => 72,
            'rateAccruedHourly' => 0.25,
            'scheduleOfAccrualDate' => '2026-04-01',
        ]);

        self::assertSame('leave-type-1', $leaveType->getLeaveTypeID());
        self::assertSame('OnAnniversaryDate', $leaveType->getScheduleOfAccrual());
        self::assertSame(200.0, $leaveType->getHoursAccruedAnnually());
        self::assertSame(80.0, $leaveType->getMaximumToAccrue());
        self::assertSame(72.0, $leaveType->getOpeningBalance());
        self::assertSame(0.25, $leaveType->getRateAccruedHourly());
        self::assertSame('2026-04-01', $leaveType->getScheduleOfAccrualDate());
    }

    public function test_leave_payloads_send_idempotency_keys(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'EmployeeLeave' => ['LeaveID' => 'leave-1'],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'leaveType' => ['leaveTypeID' => 'leave-type-1'],
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

    public function test_it_manages_employee_pay_template_earnings(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'payTemplate' => [
                'employeeID' => 'employee-1',
                'earningTemplates' => [[
                    'payTemplateEarningID' => 'earning-1',
                    'ratePerUnit' => 25,
                    'numberOfUnits' => 10,
                    'fixedAmount' => null,
                    'earningsRateID' => 'rate-1',
                    'name' => 'Regular Hours',
                ]],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'earningTemplate' => [
                'payTemplateEarningID' => 'earning-2',
                'ratePerUnit' => 30,
                'numberOfUnits' => 5,
                'earningsRateID' => 'rate-1',
                'name' => 'Overtime',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'earningTemplate' => [
                'payTemplateEarningID' => 'earning-2',
                'ratePerUnit' => 35,
                'numberOfUnits' => 5,
                'earningsRateID' => 'rate-1',
                'name' => 'Overtime',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '{}'));
        $transport->push(new Response(200, body: json_encode([
            'earningTemplates' => [
                ['payTemplateEarningID' => 'earning-3', 'earningsRateID' => 'rate-2', 'name' => 'Regular Hours'],
                ['payTemplateEarningID' => 'earning-4', 'earningsRateID' => 'rate-3', 'name' => 'Overtime Hours'],
            ],
        ], JSON_THROW_ON_ERROR)));

        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->employees();

        $templates = $employees->payTemplate('employee-1');
        $created = $employees->createEarningsTemplate(
            'employee-1',
            (new EarningsTemplate())->setRatePerUnit(30.0)->setNumberOfUnits(5.0)->setEarningsRateID('rate-1'),
            'create-key'
        );
        $updated = $employees->updateEarningsTemplate(
            'employee-1',
            'earning-2',
            (new EarningsTemplate())->setRatePerUnit(35.0)->setNumberOfUnits(5.0)->setEarningsRateID('rate-1')
        );
        $deleted = $employees->deleteEarningsTemplate('employee-1', 'earning-2');
        $bulk = $employees->createEarningsTemplates(
            'employee-1',
            [
                (new EarningsTemplate())->setEarningsRateID('rate-2')->setNumberOfUnits(8.0),
                (new EarningsTemplate())->setEarningsRateID('rate-3')->setNumberOfUnits(8.0),
            ],
            'bulk-key'
        );

        self::assertCount(1, $templates->all());
        $firstTemplate = $templates->first();
        self::assertNotNull($firstTemplate);
        self::assertSame('earning-1', $firstTemplate->getPayTemplateEarningID());
        self::assertSame(25.0, $firstTemplate->getRatePerUnit());
        self::assertSame('Regular Hours', $firstTemplate->getName());

        $getRequest = $transport->requests()[0];
        self::assertSame('GET', $getRequest->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PayTemplates', $getRequest->path);

        $createRequest = $transport->requests()[1];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PayTemplates/earnings', $createRequest->path);
        self::assertSame('create-key', $createRequest->headers['Idempotency-Key']);
        self::assertSame([
            'ratePerUnit' => 30.0,
            'numberOfUnits' => 5.0,
            'earningsRateID' => 'rate-1',
        ], $createRequest->json);
        self::assertSame('earning-2', $created->getPayTemplateEarningID());

        $updateRequest = $transport->requests()[2];
        self::assertSame('PUT', $updateRequest->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PayTemplates/earnings/earning-2', $updateRequest->path);
        self::assertArrayNotHasKey('Idempotency-Key', $updateRequest->headers);
        self::assertSame(35.0, $updated->getRatePerUnit());

        self::assertSame('DELETE', $transport->requests()[3]->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/PayTemplates/earnings/earning-2', $transport->requests()[3]->path);
        self::assertTrue($deleted);

        $bulkRequest = $transport->requests()[4];
        self::assertSame('POST', $bulkRequest->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/paytemplateearnings', $bulkRequest->path);
        self::assertSame('application/json', $bulkRequest->headers['Content-Type']);
        self::assertSame('bulk-key', $bulkRequest->headers['Idempotency-Key']);
        self::assertSame(
            json_encode([
                ['numberOfUnits' => 8.0, 'earningsRateID' => 'rate-2'],
                ['numberOfUnits' => 8.0, 'earningsRateID' => 'rate-3'],
            ], JSON_THROW_ON_ERROR),
            $bulkRequest->body
        );
        self::assertCount(2, $bulk->all());
        $firstBulk = $bulk->first();
        self::assertNotNull($firstBulk);
        self::assertSame('earning-3', $firstBulk->getPayTemplateEarningID());
    }

    public function test_it_hydrates_every_earnings_template_field(): void
    {
        $template = (new EarningsTemplate())->fill([
            'payTemplateEarningID' => 'earning-1',
            'ratePerUnit' => 25.5,
            'numberOfUnits' => 10,
            'fixedAmount' => 100,
            'earningsRateID' => 'rate-1',
            'name' => 'Regular Hours',
        ]);

        self::assertSame('earning-1', $template->getPayTemplateEarningID());
        self::assertSame(25.5, $template->getRatePerUnit());
        self::assertSame(10.0, $template->getNumberOfUnits());
        self::assertSame(100.0, $template->getFixedAmount());
        self::assertSame('rate-1', $template->getEarningsRateID());
        self::assertSame('Regular Hours', $template->getName());
        self::assertSame([
            'payTemplateEarningID' => 'earning-1',
            'ratePerUnit' => 25.5,
            'numberOfUnits' => 10.0,
            'fixedAmount' => 100.0,
            'earningsRateID' => 'rate-1',
            'name' => 'Regular Hours',
        ], $template->toRequest());
    }

    public function test_it_reads_creates_and_updates_opening_balances(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'openingBalances' => [
                'statutoryAdoptionPay' => 10,
                'statutoryMaternityPay' => 10,
                'statutoryPaternityPay' => 10,
                'statutorySharedParentalPay' => 10,
                'statutorySickPay' => 10,
                'priorEmployeeNumber' => 10,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'openingBalances' => null,
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'openingBalances' => [
                'statutorySickPay' => 20,
            ],
        ], JSON_THROW_ON_ERROR)));

        $employees = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->employees();

        $balances = $employees->openingBalances('employee-1');
        $created = $employees->createOpeningBalances(
            'employee-1',
            (new EmployeeOpeningBalances())->setStatutorySickPay(10.0)->setStatutoryMaternityPay(10.0),
            'create-key'
        );
        $updated = $employees->updateOpeningBalances(
            'employee-1',
            (new EmployeeOpeningBalances())->setStatutorySickPay(20.0)
        );

        self::assertSame(10.0, $balances->getStatutoryAdoptionPay());
        self::assertSame(10.0, $balances->getStatutoryMaternityPay());
        self::assertSame(10.0, $balances->getStatutoryPaternityPay());
        self::assertSame(10.0, $balances->getStatutorySharedParentalPay());
        self::assertSame(10.0, $balances->getStatutorySickPay());
        self::assertSame(10.0, $balances->getPriorEmployeeNumber());

        $getRequest = $transport->requests()[0];
        self::assertSame('GET', $getRequest->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/ukopeningbalances', $getRequest->path);

        $createRequest = $transport->requests()[1];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/ukopeningbalances', $createRequest->path);
        self::assertSame('create-key', $createRequest->headers['Idempotency-Key']);
        self::assertSame([
            'statutoryMaternityPay' => 10.0,
            'statutorySickPay' => 10.0,
        ], $createRequest->json);
        self::assertNull($created->getStatutorySickPay());

        $updateRequest = $transport->requests()[2];
        self::assertSame('PUT', $updateRequest->method);
        self::assertSame('/payroll.xro/2.0/Employees/employee-1/ukopeningbalances', $updateRequest->path);
        self::assertArrayNotHasKey('Idempotency-Key', $updateRequest->headers);
        self::assertSame(['statutorySickPay' => 20.0], $updateRequest->json);
        self::assertSame(20.0, $updated->getStatutorySickPay());
    }
}
