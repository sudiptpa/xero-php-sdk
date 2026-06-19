# Payroll AU

AU payroll resources.

## Payroll calendars

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
    ->email('grace@example.test')
    ->save();
```

```php
$leaveBalances = $employee->getLeaveBalances();

$leave = $employee->createLeaveApplication()
    ->leaveType('leave-type-id')
    ->title('Annual Leave')
    ->startDate('2026-04-01')
    ->endDate('2026-04-02')
    ->save();
```

## Leave applications

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

## Pay items

```php
$payItems = $xero->payroll()
    ->au()
    ->payItems()
    ->page(1)
    ->get();

$earningsRates = $payItems->first()?->getEarningsRates();
```

## Pay runs

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
$payRun = $xero->payroll()
    ->au()
    ->payRuns()
    ->find('payrun-id');

$payslips = $payRun?->payslips();
$netPay = $payslips?->first()?->getNetPay();
```

For the full payslip with all line items:

```php
$payslip = $xero->payroll()
    ->au()
    ->payRuns()
    ->payslip('payslip-id');

$earningsLines = $payslip?->getEarningsLines();
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

## Super funds

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

$productName = $products->first()?->getProductName();
```

## Scopes

- `payroll.employees.read` / `payroll.employees`: employees and leave applications
- `payroll.settings.read` / `payroll.settings`: pay items, settings, payroll calendars, super funds
- `payroll.payruns.read` / `payroll.payruns`: pay runs
- `payroll.timesheets.read` / `payroll.timesheets`: timesheets
