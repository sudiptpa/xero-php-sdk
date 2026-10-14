# Payroll UK

UK payroll resources.

## Employees

Employee contracts expose `employmentStatus` through
`$employee->getContracts()[0]->getEmploymentStatus()`. Supported spec values are
`Employee`, `Worker`, `Unspecified`, and `OffPayrollWorker`. The separate
`$employee->getIsOffPayrollWorker()` method reads the employee-level boolean.

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

Call `leavePeriods()` without dates to return all available periods, or pass a
start date, an end date, or both to limit the result.

```php
$createdLeave = $employee->createLeave()
    ->leaveType('leave-type-id')
    ->description('Holiday')
    ->startDate('2026-04-01')
    ->endDate('2026-04-03')
    ->periods([[
        'periodStartDate' => '2026-04-01',
        'periodEndDate' => '2026-04-03',
        'numberOfUnits' => 3,
    ]])
    ->save();

$createdLeaveType = $employee->createLeaveType()
    ->leaveType('leave-type-id')
    ->scheduleOfAccrual('OnAnniversaryDate')
    ->openingBalance(12.5)
    ->hoursAccruedAnnually(120)
    ->maximumToAccrue(240)
    ->scheduleOfAccrualDate('2026-04-01')
    ->save();
```

## Leave types

```php
$leaveTypes = $xero->payroll()
    ->uk()
    ->leaveTypes()
    ->get();

$leaveTypeId = $leaveTypes->first()?->getLeaveTypeID();
$leaveType = $xero->payroll()->uk()->leaveTypes()->find('leave-type-id');
```

```php
$leaveType = $xero->payroll()
    ->uk()
    ->leaveTypes()
    ->create([
        'name' => 'Volunteer Day',
        'isPaidLeave' => true,
    ]);
```

## Pay run calendars

```php
$calendars = $xero->payroll()
    ->uk()
    ->payRunCalendars()
    ->get();

$calendarName = $calendars->first()?->getName();
```

```php
$calendar = $xero->payroll()
    ->uk()
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
    ->uk()
    ->payRuns()
    ->status('Draft')
    ->get();

$payRunId = $payRuns->first()?->getPayRunID();
```

UK pay runs are read-only in this API. The SDK supports listing and finding pay
runs, but does not expose pay-run creation.

```php
$payslips = $xero->payroll()
    ->uk()
    ->payRuns()
    ->payslips('payrun-id')
    ->get(page: 2);

$totalPay = $payslips->first()?->getTotalPay();
$earnings = $payslips->first()?->getEarningsLines();
```

## Timesheets

```php
$timesheets = $xero->payroll()
    ->uk()
    ->timesheets()
    ->status('Draft')
    ->filter('employeeId==employee-id')
    ->startDate('2026-03-01')
    ->endDate('2026-03-31')
    ->sort('startDate')
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
    ->status('Draft')
    ->save();
```

```php
$approved = $timesheet->approve();
$reverted = $approved->revert();
```

## Settings

```php
$settings = $xero->payroll()
    ->uk()
    ->settings()
    ->get();

$accounts = $settings->getAccounts();
$accountName = $accounts[0]->getName() ?? null;
```

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
    ->statutoryLeaveSummary('employee-id', activeOnly: true);

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
- `payroll.payslip.read` / `payroll.payslip`: payslips
- `payroll.timesheets.read` / `payroll.timesheets`: timesheets
