# Payroll UK

Payroll UK is close to NZ in some places and different in others. The package keeps the UK-specific parts explicit.

Current coverage:

- employees
- employee leave balances
- employee statutory leave balance
- employee leave records and payment method helpers
- pay run calendars
- pay runs
- pay run payslips
- timesheets
- settings helpers for tracking categories, reimbursements, and statutory leave summary

## Employees

```php
$employees = $xero->payroll()
    ->uk()
    ->employees()
    ->filter('Ada')
    ->page(1)
    ->get();
```

```php
$employee = $xero->payroll()
    ->uk()
    ->employees()
    ->create()
    ->firstName('Grace')
    ->lastName('Hopper')
    ->emailAddress('grace@example.test')
    ->save();
```

```php
$balances = $employee->leaveBalances();

$statutory = $employee->statutoryLeaveBalance();

$leaves = $employee->leaves();

$paymentMethod = $employee->paymentMethod();
```

## Pay Run Calendars

```php
$calendars = $xero->payroll()
    ->uk()
    ->payRunCalendars()
    ->get();
```

## Pay Runs

```php
$payRuns = $xero->payroll()
    ->uk()
    ->payRuns()
    ->status('DRAFT')
    ->get();
```

```php
$payRun = $xero->payroll()
    ->uk()
    ->payRuns()
    ->create()
    ->payrollCalendar('calendar-id')
    ->save();
```

```php
$payslips = $xero->payroll()
    ->uk()
    ->payRuns()
    ->payslips('payrun-id')
    ->get();
```

## Timesheets

```php
$timesheets = $xero->payroll()
    ->uk()
    ->timesheets()
    ->status('DRAFT')
    ->get();
```

```php
$timesheet = $xero->payroll()
    ->uk()
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
$trackingCategories = $xero->payroll()
    ->uk()
    ->settings()
    ->trackingCategories();
```

```php
$summary = $xero->payroll()
    ->uk()
    ->settings()
    ->statutoryLeaveSummary('employee-id');
```

## Scope Notes

Payroll UK uses several scope families:

- employees and employee leave balances: broad `payroll.employees`, granular `payroll.employees.read`, `payroll.employees`
- pay run calendars: broad `payroll.settings`, granular `payroll.settings.read`, `payroll.settings`
- pay runs: broad `payroll.payruns`, granular `payroll.payruns.read`, `payroll.payruns`
- timesheets: broad `payroll.timesheets`, granular `payroll.timesheets.read`, `payroll.timesheets`
