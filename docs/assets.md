# Assets

Fixed assets, asset types, and depreciation settings.

## List assets

```php
$assets = $xero->assets()
    ->status('registered')
    ->page(1)
    ->perPage(25)
    ->orderBy('AssetName', 'ASC')
    ->filterBy('MacBook')
    ->get();
```

## Create an asset

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

## Find an asset

```php
$asset = $xero->assets()->find('asset-id');

$status = $asset->getAssetStatus();
$assetTypeId = $asset->getAssetTypeId();
```

## Paginate

```php
$page = $xero->assets()
    ->status('draft')
    ->paginate(page: 2, perPage: 10);
```

## Asset types

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

$prefix = $settings->getAssetNumberPrefix();
$optInForTax = $settings->getOptInForTax();
```

## Scopes

- `assets.read` — read assets, asset types, and settings
- `assets` — create assets and asset types
