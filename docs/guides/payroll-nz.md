# Payroll NZ

NZ payroll resources and employee helpers.

## Employees

```php
$employees = $xero->payroll()
    ->nz()
    ->employees()
    ->filter('Ada')
    ->page(1)
    ->get();

$employeeName = $employees->first()?->getFirstName();
```

```php
$employee = $xero->payroll()
    ->nz()
    ->employees()
    ->create()
    ->firstName('Grace')
    ->lastName('Hopper')
    ->emailAddress('grace@example.test')
    ->save();
```

```php
$leaveTypes = $employee->leaveTypes();
$leavePeriods = $employee->leavePeriods('2026-01-01', '2026-03-31');
$leaveBalances = $employee->leaveBalances();
$leaves = $employee->leaves();
$paymentMethod = $employee->paymentMethod();
$tax = $employee->tax();
$workingPatterns = $employee->workingPatterns();
$salaryAndWages = $employee->salaryAndWages(page: 2);
$salaryAndWage = $employee->salaryAndWage('salary-id');
```

```php
$employment = $employee->createEmployment()
    ->startDate('2026-04-01')
    ->payrollCalendar('calendar-id')
    ->save();

$leave = $employee->createLeave()
    ->leaveType('leave-type-id')
    ->description('Annual leave')
    ->startDate('2026-04-10')
    ->endDate('2026-04-11')
    ->save();

$paymentMethod = $employee->createPaymentMethod()
    ->bankAccount('Jane Doe', '12123412345670', '123456')
    ->save();

$salaryAndWage = $employee->createSalaryAndWage()
    ->paymentType('SALARY')
    ->earningsRate('earning-rate-id')
    ->numberOfUnitsPerWeek(40)
    ->numberOfUnitsPerDay(8)
    ->daysPerWeek(5)
    ->effectiveFrom('2026-04-01')
    ->annualSalary(85000)
    ->status('Active')
    ->save();

$workingPattern = $employee->createWorkingPattern()
    ->effectiveFrom('2026-04-01')
    ->workingWeek(monday: 8, tuesday: 8, wednesday: 8, thursday: 8, friday: 8, saturday: 0, sunday: 0)
    ->save();
```

```php
$leaveSetup = $employee->leaveSetup()
    ->includeHolidayPay(true)
    ->holidayPayOpeningBalance(10)
    ->annualLeaveOpeningBalance(100)
    ->sickLeaveScheduleOfAccrual('OnAnniversaryDate')
    ->save();

$openingBalances = $employee->openingBalances()
    ->periodEndDate('2026-03-31')
    ->daysPaid(5)
    ->grossEarnings(1730.77)
    ->save();
```

## Leave types

```php
$leaveTypes = $xero->payroll()
    ->nz()
    ->leaveTypes()
    ->activeOnly()
    ->get();

$leaveTypeId = $leaveTypes->first()?->getLeaveTypeID();
```

```php
$leaveType = $xero->payroll()
    ->nz()
    ->leaveTypes()
    ->create([
        'name' => 'Volunteer Day',
        'isPaidLeave' => true,
    ]);
```

## Pay run calendars

```php
$calendars = $xero->payroll()
    ->nz()
    ->payRunCalendars()
    ->get();

$calendarName = $calendars->first()?->getName();
```

```php
$calendar = $xero->payroll()
    ->nz()
    ->payRunCalendars()
    ->create([
        'name' => 'Weekly',
        'calendarType' => 'WEEKLY',
        'startDate' => '2026-04-01',
        'paymentDate' => '2026-04-08',
    ]);
```

## Pay runs

```php
$payRuns = $xero->payroll()
    ->nz()
    ->payRuns()
    ->status('DRAFT')
    ->get();

$payRunId = $payRuns->first()?->getPayRunID();
```

```php
$payRun = $xero->payroll()
    ->nz()
    ->payRuns()
    ->create()
    ->payrollCalendar('calendar-id')
    ->save();
```

## Timesheets

```php
$timesheets = $xero->payroll()
    ->nz()
    ->timesheets()
    ->status('DRAFT')
    ->get();

$timesheetId = $timesheets->first()?->getTimesheetID();
```

```php
$timesheet = $xero->payroll()
    ->nz()
    ->timesheets()
    ->create()
    ->employee('employee-id')
    ->startDate('2026-03-23')
    ->endDate('2026-03-29')
    ->status('DRAFT')
    ->save();
```

```php
$approved = $timesheet->approve();
$reverted = $approved->revert();
```

## Settings

```php
$settings = $xero->payroll()
    ->nz()
    ->settings()
    ->get();

$accounts = $settings->getAccounts();
```

```php
$updated = $xero->payroll()
    ->nz()
    ->settings()
    ->update($accounts); // full accounts array: one each of BANK, PAYELIABILITY, WAGESEXPENSE, WAGESPAYABLE
```

```php
$deductions = $xero->payroll()
    ->nz()
    ->settings()
    ->statutoryDeductions();

$deductionName = $deductions->first()?->getName();
```

```php
$reimbursement = $xero->payroll()
    ->nz()
    ->settings()
    ->createReimbursement()
    ->name('Mileage')
    ->account('account-id')
    ->category('NonTaxable')
    ->calculationType('FixedAmount')
    ->standardAmount('25.00')
    ->standardTypeOfUnits('Kilometres')
    ->standardRatePerUnit(0.95)
    ->save();

$reimbursementId = $reimbursement->getReimbursementID();
```

## Scopes

- `payroll.employees.read` / `payroll.employees`: employees
- `payroll.settings.read` / `payroll.settings`: leave types, pay run calendars, settings
- `payroll.payruns.read` / `payroll.payruns`: pay runs
- `payroll.timesheets.read` / `payroll.timesheets`: timesheets
