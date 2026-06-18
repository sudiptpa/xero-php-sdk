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
$employment = $employee->employment();
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
    ->startDate('2026-04-10')
    ->endDate('2026-04-11')
    ->save();

$paymentMethod = $employee->createPaymentMethod()
    ->bankAccountNumber('12-1234-1234567-00')
    ->save();

$salaryAndWage = $employee->createSalaryAndWage()
    ->paymentType('HOURLY')
    ->earningsRate('earning-rate-id')
    ->save();

$workingPattern = $employee->createWorkingPattern()
    ->effectiveFrom('2026-04-01')
    ->save();
```

```php
$leaveSetup = $employee->leaveSetup()
    ->leaveType('leave-type-id')
    ->scheduleOfAccrual('ON_ANNIVERSARY_DATE')
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

## Pay run calendars

```php
$calendars = $xero->payroll()
    ->nz()
    ->payRunCalendars()
    ->get();

$calendarName = $calendars->first()?->getName();
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
$deductions = $xero->payroll()
    ->nz()
    ->settings()
    ->statutoryDeductions();

$deductionName = $deductions->first()?->getName();
```

## Scopes

- `payroll.employees.read` / `payroll.employees` — employees
- `payroll.settings.read` / `payroll.settings` — leave types, pay run calendars, settings
- `payroll.payruns.read` / `payroll.payruns` — pay runs
- `payroll.timesheets.read` / `payroll.timesheets` — timesheets
