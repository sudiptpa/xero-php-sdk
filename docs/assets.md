# Assets

The Assets API has a smaller surface than Accounting, but it still needs to feel deliberate.

The current package slice covers:

- fixed assets
- asset types
- asset settings

## Assets

```php
$assets = $xero->assets()->get();
```

```php
$asset = $xero->assets()
    ->create()
    ->name('MacBook Pro')
    ->number('FA-1001')
    ->status('draft')
    ->assetType('asset-type-id')
    ->purchaseDate('2026-03-25')
    ->purchasePrice(2400)
    ->save();
```

```php
$asset = $xero->assets()->find('asset-id');
```

## Asset Types

```php
$types = $xero->assets()
    ->assetTypes()
    ->get();
```

```php
$type = $xero->assets()
    ->createAssetType()
    ->name('Computer Equipment')
    ->fixedAssetAccount('account-id')
    ->depreciationExpenseAccount('expense-account-id')
    ->accumulatedDepreciationAccount('accumulated-account-id')
    ->depreciationMethod('DiminishingValue100')
    ->averagingMethod('ActualDays')
    ->depreciationRate(40)
    ->save();
```

## Settings

```php
$settings = $xero->assets()->settings();
```

## Scope Notes

- broad scope: `assets`
- granular scopes: `assets.read`, `assets`

Read operations can use `assets.read`. Create operations need `assets`.
