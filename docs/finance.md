# Finance

Read-only finance statements and bank statement analysis.

## Bank statement accounting

```php
$result = $xero->finance()
    ->bankStatementAccounting()
    ->get(
        'bank-account-id',
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );

$accountName = $result->getBankAccountName();
$statements = $result->getStatements();
```

## Cash validation

```php
$results = $xero->finance()
    ->cashValidation()
    ->get(new DateTimeImmutable('2026-03-31'));

$accountId = $results->first()?->getAccountId();
$statementBalance = $results->first()?->getStatementBalance();
```

## Balance sheet

```php
$balanceSheet = $xero->finance()
    ->statements()
    ->balanceSheet(new DateTimeImmutable('2026-03-31'));

$asset = $balanceSheet->getAsset();
$liability = $balanceSheet->getLiability();
$equity = $balanceSheet->getEquity();
```

## Profit and loss

```php
$profitAndLoss = $xero->finance()
    ->statements()
    ->profitAndLoss(
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );

$revenue = $profitAndLoss->getRevenue();
$expense = $profitAndLoss->getExpense();
$netProfitLoss = $profitAndLoss->getNetProfitLoss();
```

## Cashflow

```php
$cashflow = $xero->finance()
    ->statements()
    ->cashflow(
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );
```

## Trial balance

```php
$trialBalance = $xero->finance()
    ->statements()
    ->trialBalance(new DateTimeImmutable('2026-03-31'));
```

## Contact revenue

```php
$contactRevenue = $xero->finance()
    ->statements()
    ->contactRevenue(
        ['contact-id'],
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );

$total = $contactRevenue->getTotal();
$contacts = $contactRevenue->getContacts();
```

## Contact expenses

```php
$contactExpenses = $xero->finance()
    ->statements()
    ->contactExpenses(
        ['contact-id'],
        new DateTimeImmutable('2026-03-01'),
        new DateTimeImmutable('2026-03-31'),
    );
```

## Scopes

- `finance.cashvalidation.read` — cash validation
- `finance.statements.read` — balance sheet, cashflow, profit and loss, trial balance, contact revenue, contact expenses
- `finance.bankstatementsplus.read` — bank statement accounting
