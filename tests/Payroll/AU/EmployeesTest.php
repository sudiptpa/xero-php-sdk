<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use PHPUnit\Framework\TestCase;
use DateTimeImmutable;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\Employee;
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
                'Email' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Jane',
                'LastName' => 'Smith',
                'Email' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'Email' => 'grace@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'Email' => 'grace@example.test',
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
            ->email('grace@example.test')
            ->save();
        $updated = $client->payroll()->au()->employees()->update('employee-2')
            ->firstName('Grace')
            ->lastName('Hopper')
            ->email('grace@example.test')
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

    public function test_it_can_create_a_leave_application_for_an_employee(): void
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
            'LeaveApplication' => [
                'LeaveApplicationID' => 'leave-1',
                'EmployeeID' => 'employee-1',
                'Title' => 'Annual Leave',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employee = $client->payroll()->au()->employees()->find('employee-1');
        $leaveApplication = $employee?->createLeaveApplication()
            ->leaveType('leave-type-1')
            ->title('Annual Leave')
            ->startDate('2026-04-01')
            ->endDate('2026-04-02')
            ->save();

        self::assertSame('/payroll.xro/1.0/Employees/employee-1', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/1.0/LeaveApplications', $transport->requests()[1]->path);
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
                'Email' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Janet',
                'LastName' => 'Smithson',
                'Email' => 'janet@example.test',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employee = $client->payroll()->au()->employees()->find('employee-1');
        self::assertNotNull($employee);
        self::assertSame('Smith', $employee->getLastName());
        self::assertSame('jane@example.test', $employee->getEmail());
        self::assertSame('ACTIVE', $employee->getStatus());

        $saved = $employee
            ->setFirstName('Janet')
            ->setLastName('Smithson')
            ->setEmail('janet@example.test')
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

    public function test_employee_exposes_all_spec_fields(): void
    {
        $employee = (new Employee())->fill([
            'EmployeeID' => 'employee-1',
            'FirstName' => 'Jane',
            'LastName' => 'Smith',
            'DateOfBirth' => '1990-01-15',
            'StartDate' => '2020-02-01',
            'Title' => 'Mrs',
            'MiddleNames' => 'Adena',
            'Email' => 'jane@example.test',
            'Gender' => 'F',
            'Phone' => '415-555-1212',
            'Mobile' => '415-234-5678',
            'TwitterUserName' => 'xeroapi',
            'IsAuthorisedToApproveLeave' => true,
            'IsAuthorisedToApproveTimesheets' => true,
            'JobTitle' => 'Manager',
            'Classification' => '99383',
            'OrdinaryEarningsRateID' => 'rate-1',
            'PayrollCalendarID' => 'calendar-1',
            'EmployeeGroupName' => 'marketing',
            'TerminationDate' => '2026-03-01',
            'TerminationReason' => 'V',
            'IncomeType' => 'SALARYANDWAGES',
            'EmploymentType' => 'EMPLOYEE',
            'CountryOfResidence' => 'AU',
            'IsSTP2Qualified' => true,
            'Status' => 'ACTIVE',
            'UpdatedDateUTC' => '2026-03-25T00:00:00Z',
            'ValidationErrors' => [['Message' => 'Invalid employee']],
            'HomeAddress' => [
                'AddressLine1' => '123 Main St',
                'AddressLine2' => 'Apt 4',
                'City' => 'St. Kilda',
                'Region' => 'VIC',
                'PostalCode' => '3182',
                'Country' => 'AUSTRALIA',
            ],
            'TaxDeclaration' => [
                'EmployeeID' => 'employee-1',
                'EmploymentBasis' => 'FULLTIME',
                'TFNExemptionType' => 'NOTQUOTED',
                'TaxFileNumber' => '123123123',
                'ABN' => '21006819692',
                'AustralianResidentForTaxPurposes' => true,
                'ResidencyStatus' => 'AUSTRALIANRESIDENT',
                'TaxScaleType' => 'REGULAR',
                'WorkCondition' => 'NONE',
                'SeniorMaritalStatus' => 'SINGLE',
                'TaxFreeThresholdClaimed' => true,
                'TaxOffsetEstimatedAmount' => 100,
                'HasHELPDebt' => false,
                'HasSFSSDebt' => false,
                'HasTradeSupportLoanDebt' => false,
                'UpwardVariationTaxWithholdingAmount' => 50,
                'EligibleToReceiveLeaveLoading' => false,
                'ApprovedWithholdingVariationPercentage' => 75,
                'HasStudentStartupLoan' => true,
                'HasLoanOrStudentDebt' => true,
                'UpdatedDateUTC' => '2026-03-25T00:00:00Z',
                'IncludeLeaveLoadingInQualifyingEarnings' => true,
            ],
        ]);

        self::assertSame('employee-1', $employee->getEmployeeID());
        self::assertSame('Jane', $employee->getFirstName());
        self::assertSame('Smith', $employee->getLastName());
        self::assertSame('1990-01-15', $employee->getDateOfBirth());
        self::assertSame('2020-02-01', $employee->getStartDate());
        self::assertSame('Mrs', $employee->getTitle());
        self::assertSame('Adena', $employee->getMiddleNames());
        self::assertSame('jane@example.test', $employee->getEmail());
        self::assertSame('F', $employee->getGender());
        self::assertSame('415-555-1212', $employee->getPhone());
        self::assertSame('415-234-5678', $employee->getMobile());
        self::assertSame('xeroapi', $employee->getTwitterUserName());
        self::assertTrue($employee->getIsAuthorisedToApproveLeave());
        self::assertTrue($employee->getIsAuthorisedToApproveTimesheets());
        self::assertSame('Manager', $employee->getJobTitle());
        self::assertSame('99383', $employee->getClassification());
        self::assertSame('rate-1', $employee->getOrdinaryEarningsRateID());
        self::assertSame('calendar-1', $employee->getPayrollCalendarID());
        self::assertSame('marketing', $employee->getEmployeeGroupName());
        self::assertSame('2026-03-01', $employee->getTerminationDate());
        self::assertSame('V', $employee->getTerminationReason());
        self::assertSame('SALARYANDWAGES', $employee->getIncomeType());
        self::assertSame('EMPLOYEE', $employee->getEmploymentType());
        self::assertSame('AU', $employee->getCountryOfResidence());
        self::assertTrue($employee->getIsSTP2Qualified());
        self::assertSame('ACTIVE', $employee->getStatus());
        self::assertSame('2026-03-25T00:00:00Z', $employee->getUpdatedDateUTC());
        self::assertCount(1, $employee->getValidationErrors());
        self::assertSame('Invalid employee', $employee->getValidationErrors()[0]->getMessage());

        $homeAddress = $employee->getHomeAddress();
        self::assertNotNull($homeAddress);
        self::assertSame('123 Main St', $homeAddress->getAddressLine1());
        self::assertSame('Apt 4', $homeAddress->getAddressLine2());
        self::assertSame('St. Kilda', $homeAddress->getCity());
        self::assertSame('VIC', $homeAddress->getRegion());
        self::assertSame('3182', $homeAddress->getPostalCode());
        self::assertSame('AUSTRALIA', $homeAddress->getCountry());

        $taxDeclaration = $employee->getTaxDeclaration();
        self::assertNotNull($taxDeclaration);
        self::assertSame('employee-1', $taxDeclaration->getEmployeeID());
        self::assertSame('FULLTIME', $taxDeclaration->getEmploymentBasis());
        self::assertSame('NOTQUOTED', $taxDeclaration->getTFNExemptionType());
        self::assertSame('123123123', $taxDeclaration->getTaxFileNumber());
        self::assertSame('21006819692', $taxDeclaration->getABN());
        self::assertTrue($taxDeclaration->getAustralianResidentForTaxPurposes());
        self::assertSame('AUSTRALIANRESIDENT', $taxDeclaration->getResidencyStatus());
        self::assertSame('REGULAR', $taxDeclaration->getTaxScaleType());
        self::assertSame('NONE', $taxDeclaration->getWorkCondition());
        self::assertSame('SINGLE', $taxDeclaration->getSeniorMaritalStatus());
        self::assertTrue($taxDeclaration->getTaxFreeThresholdClaimed());
        self::assertSame(100.0, $taxDeclaration->getTaxOffsetEstimatedAmount());
        self::assertFalse($taxDeclaration->getHasHELPDebt());
        self::assertFalse($taxDeclaration->getHasSFSSDebt());
        self::assertFalse($taxDeclaration->getHasTradeSupportLoanDebt());
        self::assertSame(50.0, $taxDeclaration->getUpwardVariationTaxWithholdingAmount());
        self::assertFalse($taxDeclaration->getEligibleToReceiveLeaveLoading());
        self::assertSame(75.0, $taxDeclaration->getApprovedWithholdingVariationPercentage());
        self::assertTrue($taxDeclaration->getHasStudentStartupLoan());
        self::assertTrue($taxDeclaration->getHasLoanOrStudentDebt());
        self::assertSame('2026-03-25T00:00:00Z', $taxDeclaration->getUpdatedDateUTC());
        self::assertTrue($taxDeclaration->getIncludeLeaveLoadingInQualifyingEarnings());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Employee())->save();
    }

    public function test_create_leave_application_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Employee())->createLeaveApplication();
    }
}
