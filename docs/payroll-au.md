# Payroll AU

Payroll AU has its own rules and query style. The package keeps that explicit instead of pretending it is the same as Accounting.

Current coverage:

- payroll calendars
- employees
- employee leave balances
- employee-scoped leave application helper
- leave applications
- pay items
- pay runs
- pay slips
- timesheets
- settings
- super funds
- super fund products
- employee find and write flows
- super fund create flow

## Payroll Calendars

```php
$calendars = $xero->payroll()
    ->au()
    ->payrollCalendars()
    ->get();

$firstCalendarName = $calendars->first()?->getName();
```

```php
$calendar = $xero->payroll()
    ->au()
    ->payrollCalendars()
    ->create()
    ->name('Weekly')
    ->calendarType('WEEKLY')
    ->startDate('2026-04-01')
    ->paymentDate('2026-04-08')
    ->save();
```

## Employees

```php
$employees = $xero->payroll()
    ->au()
    ->employees()
    ->where('Status=="ACTIVE"')
    ->orderBy('LastName ASC')
    ->page(1)
    ->get();
```

```php
$employee = $xero->payroll()
    ->au()
    ->employees()
    ->find('employee-id');

$employeeId = $employee?->getEmployeeID();
$firstName = $employee?->getFirstName();
```

```php
$employee = $xero->payroll()
    ->au()
    ->employees()
    ->create()
    ->firstName('Grace')
    ->lastName('Hopper')
    ->emailAddress('grace@example.test')
    ->save();
```

```php
$leaveBalances = $employee->leaveBalances();

$leave = $employee->createLeaveApplication()
    ->leaveType('leave-type-id')
    ->title('Annual Leave')
    ->startDate('2026-04-01')
    ->endDate('2026-04-02')
    ->save();
```

## Leave Applications

```php
$leaveApplications = $xero->payroll()
    ->au()
    ->leaveApplications()
    ->where('Status=="REQUESTED"')
    ->get();

$status = $leaveApplications->first()?->getStatus();
```

```php
$leave = $xero->payroll()
    ->au()
    ->leaveApplications()
    ->create()
    ->employee('employee-id')
    ->leaveType('leave-type-id')
    ->title('Annual Leave')
    ->startDate('2026-04-01')
    ->endDate('2026-04-02')
    ->save();
```

## Pay Items

```php
$payItems = $xero->payroll()
    ->au()
    ->payItems()
    ->page(1)
    ->get();

$earningsRates = $payItems->first()?->getEarningsRates();
```

## Pay Runs

```php
$payRuns = $xero->payroll()
    ->au()
    ->payRuns()
    ->where('Status=="DRAFT"')
    ->get();

$payRunId = $payRuns->first()?->getPayRunID();
$payRunStatus = $payRuns->first()?->getPayRunStatus();
```

```php
$payRun = $xero->payroll()
    ->au()
    ->payRuns()
    ->create()
    ->payrollCalendar('calendar-id')
    ->save();
```

```php
$payslips = $xero->payroll()
    ->au()
    ->payRuns()
    ->payslips('payrun-id')
    ->get();

$netPay = $payslips->first()?->getNetPay();
```

## Timesheets

```php
$timesheets = $xero->payroll()
    ->au()
    ->timesheets()
    ->where('Status=="DRAFT"')
    ->get();

$timesheetId = $timesheets->first()?->getTimesheetID();
$timesheetStatus = $timesheets->first()?->getStatus();
```

```php
$timesheet = $xero->payroll()
    ->au()
    ->timesheets()
    ->create()
    ->employee('employee-id')
    ->startDate('2026-03-23')
    ->endDate('2026-03-29')
    ->status('DRAFT')
    ->save();
```

## Settings

```php
$settings = $xero->payroll()
    ->au()
    ->settings()
    ->get();
```

## Super Funds

```php
$superFunds = $xero->payroll()
    ->au()
    ->superFunds()
    ->get();

$fundName = $superFunds->first()?->getName();
```

```php
$superFund = $xero->payroll()
    ->au()
    ->superFunds()
    ->create()
    ->type('REGULATED')
    ->name('Future Super')
    ->uSI('40022701955002')
    ->abn('12345678901')
    ->save();
```

```php
$products = $xero->payroll()
    ->au()
    ->superFundProducts()
    ->abn('40022701955')
    ->usi('OSF0001AU')
    ->get();

$productId = $products->first()?->getSuperFundProductID();
```

## Scope Notes

Payroll AU uses several scope families:

- employees and leave applications: broad `payroll.employees`, granular `payroll.employees.read`, `payroll.employees`
- pay items and settings: broad `payroll.settings`, granular `payroll.settings.read`, `payroll.settings`
- payroll calendars and super funds: broad `payroll.settings`, granular `payroll.settings.read`, `payroll.settings`
- pay runs: broad `payroll.payruns`, granular `payroll.payruns.read`, `payroll.payruns`
- timesheets: broad `payroll.timesheets`, granular `payroll.timesheets.read`, `payroll.timesheets`
