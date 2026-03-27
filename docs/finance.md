# Finance

Finance is read-heavy and fairly narrow. The package keeps it explicit.

Important note: Xero’s changelog says the Accounting Activities API is being decommissioned effective April 6, 2026. The SDK still exposes that surface for compatibility, but new integrations should treat it as legacy.

Current coverage:

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
```

```php
$accountUsage = $xero->finance()
    ->accountingActivities()
    ->accountUsage('2025-04', '2026-03');
```

```php
$reportHistory = $xero->finance()
    ->accountingActivities()
    ->reportHistory(new DateTimeImmutable('2026-03-31'));
```

```php
$lockHistory = $xero->finance()
    ->accountingActivities()
    ->lockHistory(new DateTimeImmutable('2026-03-31'));
```

```php
$userActivities = $xero->finance()
    ->accountingActivities()
    ->userActivities('2026-02');
```

## Bank Statement Accounting

```php
$entries = $xero->finance()
    ->bankStatementAccounting()
    ->get(
        new DateTimeImmutable('2026-03-31'),
        new DateTimeImmutable('2026-03-31'),
    );
```

## Cash Validation

```php
$validation = $xero->finance()
    ->cashValidation()
    ->get(new DateTimeImmutable('2026-03-31'));
```

## Financial Statements

```php
$balanceSheet = $xero->finance()
    ->statements()
    ->balanceSheet(new DateTimeImmutable('2026-03-31'));
```

```php
$profitAndLoss = $xero->finance()
    ->statements()
    ->profitAndLoss(
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );
```

```php
$contactRevenue = $xero->finance()
    ->statements()
    ->contactRevenue(
        ['contact-id'],
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );
```

## Scope Notes

The current Finance coverage is read-only and uses:

- `finance.accountingactivity.read` for accounting activity views
- `finance.cashvalidation.read` for cash validation
- `finance.statements.read` for financial statements
