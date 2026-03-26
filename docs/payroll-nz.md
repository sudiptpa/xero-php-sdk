# Payroll NZ

Payroll NZ has its own shape, especially around leave and pay-run setup.

Current coverage:

- employees
- employee leave balances, leave records, and payment method helpers
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
```

## Leave Types

```php
$leaveTypes = $xero->payroll()
    ->nz()
    ->leaveTypes()
    ->activeOnly()
    ->get();
```

## Pay Run Calendars

```php
$calendars = $xero->payroll()
    ->nz()
    ->payRunCalendars()
    ->get();
```

## Pay Runs

```php
$payRuns = $xero->payroll()
    ->nz()
    ->payRuns()
    ->status('DRAFT')
    ->get();
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
```

```php
$deductions = $xero->payroll()
    ->nz()
    ->settings()
    ->statutoryDeductions();
```

## Scope Notes

Payroll NZ uses several scope families:

- employees: broad `payroll.employees`, granular `payroll.employees.read`, `payroll.employees`
- leave types, pay run calendars, and settings: broad `payroll.settings`, granular `payroll.settings.read`, `payroll.settings`
- pay runs: broad `payroll.payruns`, granular `payroll.payruns.read`, `payroll.payruns`
- timesheets: broad `payroll.timesheets`, granular `payroll.timesheets.read`, `payroll.timesheets`
