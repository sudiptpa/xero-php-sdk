# Assets

The Assets API is smaller than Accounting, but it still needs to feel like a real part of the package.

Current coverage:

- fixed assets
- asset types
- asset settings
- asset collection search parameters from the documented API

## Assets

```php
$assets = $xero->assets()
    ->status('registered')
    ->page(1)
    ->perPage(25)
    ->orderBy('AssetName', 'ASC')
    ->filterBy('MacBook')
    ->get();
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

$status = $asset?->getStatus();
$assetTypeId = $asset?->getAssetTypeId();
```

```php
$page = $xero->assets()
    ->status('draft')
    ->paginate(page: 2, perPage: 10);
```

## Asset Types

```php
$types = $xero->assets()
    ->assetTypes()
    ->get();

$typeName = $types->first()?->getAssetTypeName();
```

```php
$types = $xero->assets()->getAssetTypes();
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

$enabled = $settings?->getDepreciationCalculationEnabled();
```

## Scope Notes

Implemented Assets resources use:

- broad `assets`
- granular `assets.read`, `assets`

Use `assets.read` for asset, asset-type, and settings reads.

Use `assets` for create flows and asset-changing actions.

If the app only reports on assets, `assets.read` is enough.
