# Payroll UK
UK payroll resources and helpers.

Coverage:

- employees
- employee leave balances
- employee statutory leave balance
- employee leave records, leave creation, leave types, leave-type creation, employment, and payment method helpers
- pay run calendars
- pay runs
- pay run payslips
- timesheets
- settings helpers for tracking categories, reimbursements, and statutory leave summary
- reimbursement create flow

## Employees

```php
$employees = $xero->payroll()
    ->uk()
    ->employees()
    ->filter('Ada')
    ->page(1)
    ->get();

$employeeId = $employees->first()?->getEmployeeID();
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

$statutory = $employee->statutoryLeaveBalance('sick', '2026-03-27');

$leaves = $employee->leaves();

$leaveTypes = $employee->leaveTypes();

$leaveTypeId = $leaveTypes->first()?->getLeaveTypeID();

$employment = $employee->employment();

$paymentMethod = $employee->paymentMethod();
```

```php
$createdLeave = $employee->createLeave()
    ->leaveType('leave-type-id')
    ->startDate('2026-04-01')
    ->endDate('2026-04-03')
    ->title('Holiday')
    ->save();

$createdLeaveType = $employee->createLeaveType()
    ->leaveType('leave-type-id')
    ->scheduleOfAccrual('OnAnniversaryDate')
    ->openingBalance(12.5)
    ->save();
```

## Pay Run Calendars

```php
$calendars = $xero->payroll()
    ->uk()
    ->payRunCalendars()
    ->get();

$calendarName = $calendars->first()?->getName();
```

## Pay Runs

```php
$payRuns = $xero->payroll()
    ->uk()
    ->payRuns()
    ->status('DRAFT')
    ->get();

$payRunId = $payRuns->first()?->getPayRunID();
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

$netPay = $payslips->first()?->getNetPay();
```

## Timesheets

```php
$timesheets = $xero->payroll()
    ->uk()
    ->timesheets()
    ->status('DRAFT')
    ->get();

$timesheetStatus = $timesheets->first()?->getStatus();
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

$trackingCategoryName = $trackingCategories->first()?->getName();
```

```php
$summary = $xero->payroll()
    ->uk()
    ->settings()
    ->statutoryLeaveSummary('employee-id');

$employeeId = $summary->getEmployeeID();
```

```php
$reimbursement = $xero->payroll()
    ->uk()
    ->settings()
    ->createReimbursement()
    ->name('Meals')
    ->accountCode('400')
    ->save();

$reimbursementId = $reimbursement->getReimbursementID();
```

## Scope Notes

Payroll UK uses several scope families:

- employees and employee leave balances: broad `payroll.employees`, granular `payroll.employees.read`, `payroll.employees`
- pay run calendars: broad `payroll.settings`, granular `payroll.settings.read`, `payroll.settings`
- pay runs: broad `payroll.payruns`, granular `payroll.payruns.read`, `payroll.payruns`
- timesheets: broad `payroll.timesheets`, granular `payroll.timesheets.read`, `payroll.timesheets`
