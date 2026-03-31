# Finance
Read-only finance statements and analysis endpoints.

Important note: Xero’s changelog says the Accounting Activities API is being decommissioned effective April 6, 2026. The SDK still exposes that surface for compatibility, but new integrations should stop building on it now and existing integrations should plan to move off it before April 6, 2026.

Coverage:

- accounting activities
  - account usage
  - lock history
  - report history
  - user activities
- bank statement accounting
- cash validation
- financial statements
  - balance sheet
  - cashflow
  - profit and loss
  - trial balance
  - contact expenses
  - contact revenue

## Accounting Activities

```php
$activities = $xero->finance()
    ->accountingActivities()
    ->get(
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );

$month = $activities->first()?->getMonth();
$income = $activities->first()?->getTotalIncome();
```

```php
$accountUsage = $xero->finance()
    ->accountingActivities()
    ->accountUsage('2025-04', '2026-03');

$accountCode = $accountUsage->first()?->getAccountCode();
$amount = $accountUsage->first()?->getAmount();
```

```php
$reportHistory = $xero->finance()
    ->accountingActivities()
    ->reportHistory(new DateTimeImmutable('2026-03-31'));

$reportName = $reportHistory->first()?->getReportName();
```

```php
$lockHistory = $xero->finance()
    ->accountingActivities()
    ->lockHistory(new DateTimeImmutable('2026-03-31'));

$lockType = $lockHistory->first()?->getLockType();
```

```php
$userActivities = $xero->finance()
    ->accountingActivities()
    ->userActivities('2026-02');

$userName = $userActivities->first()?->getFullName();
```

## Bank Statement Accounting

```php
$entries = $xero->finance()
    ->bankStatementAccounting()
    ->get(
        new DateTimeImmutable('2026-03-31'),
        new DateTimeImmutable('2026-03-31'),
    );

$accountName = $entries->first()?->getAccountName();
$statementBalance = $entries->first()?->getStatementBalance();
```

## Cash Validation

```php
$validation = $xero->finance()
    ->cashValidation()
    ->get(new DateTimeImmutable('2026-03-31'));

$status = $validation->getStatus();
$currency = $validation->getCurrency();
```

## Financial Statements

```php
$balanceSheet = $xero->finance()
    ->statements()
    ->balanceSheet(new DateTimeImmutable('2026-03-31'));

$rows = $balanceSheet->getRows();
```

```php
$profitAndLoss = $xero->finance()
    ->statements()
    ->profitAndLoss(
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );

$statementType = $profitAndLoss->getType();
```

```php
$contactRevenue = $xero->finance()
    ->statements()
    ->contactRevenue(
        ['contact-id'],
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );

$contactName = $contactRevenue->first()?->getName();
$contactTotal = $contactRevenue->first()?->getTotal();
```

## Scope Notes

The current Finance coverage is read-only and uses:

- `finance.accountingactivity.read` for accounting activity views
- `finance.cashvalidation.read` for cash validation
- `finance.statements.read` for financial statements
