# Payroll NZ
NZ payroll resources and employee-side helpers.

Coverage:

- employees
- employee leave balances, leave records, payment methods, tax, and working-pattern helpers
- employee leave setup and opening balances
- employee employment, leave, payment-method, salary-and-wages, and working-pattern create helpers
- employee employment, salary-and-wages, and single salary record helpers
- leave types
- pay run calendars
- pay runs
- timesheets
- settings
- statutory deductions

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

$leaveTypeName = $leaveTypes->first()?->getName();

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

## Leave Types

```php
$leaveTypes = $xero->payroll()
    ->nz()
    ->leaveTypes()
    ->activeOnly()
    ->get();

$leaveTypeId = $leaveTypes->first()?->getLeaveTypeID();
```

## Pay Run Calendars

```php
$calendars = $xero->payroll()
    ->nz()
    ->payRunCalendars()
    ->get();

$calendarName = $calendars->first()?->getName();
```

## Pay Runs

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

## Scope Notes

Payroll NZ uses several scope families:

- employees: broad `payroll.employees`, granular `payroll.employees.read`, `payroll.employees`
- leave types, pay run calendars, and settings: broad `payroll.settings`, granular `payroll.settings.read`, `payroll.settings`
- pay runs: broad `payroll.payruns`, granular `payroll.payruns.read`, `payroll.payruns`
- timesheets: broad `payroll.timesheets`, granular `payroll.timesheets.read`, `payroll.timesheets`
