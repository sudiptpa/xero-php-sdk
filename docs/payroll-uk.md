# Payroll UK

UK payroll resources.

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

## Pay run calendars

```php
$calendars = $xero->payroll()
    ->uk()
    ->payRunCalendars()
    ->get();

$calendarName = $calendars->first()?->getName();
```

## Pay runs

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

$totalPay = $payslips->first()?->getTotalPay();
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

$timesheetCategoryId = $trackingCategories['timesheetTrackingCategoryID'] ?? null;
```

```php
$summary = $xero->payroll()
    ->uk()
    ->settings()
    ->statutoryLeaveSummary('employee-id');

$employeeId = $summary->first()?->getEmployeeID();
```

```php
$reimbursement = $xero->payroll()
    ->uk()
    ->settings()
    ->createReimbursement()
    ->name('Meals')
    ->account('account-id')
    ->save();

$reimbursementId = $reimbursement->getReimbursementID();
```

## Scopes

- `payroll.employees.read` / `payroll.employees`: employees and leave balances
- `payroll.settings.read` / `payroll.settings`: pay run calendars, settings
- `payroll.payruns.read` / `payroll.payruns`: pay runs
- `payroll.timesheets.read` / `payroll.timesheets`: timesheets
