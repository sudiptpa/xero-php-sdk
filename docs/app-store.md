# App Store

The App Store API is small, but the path shapes are different enough that it deserves its own docs.

Current coverage:

- fetching subscriptions
- listing usage records
- creating usage records
- updating usage records

These requests are app-level rather than tenant-scoped, so the SDK does not send the Xero tenant header.

Usage writes follow the documented subscription-item path, so you set the subscription item explicitly before saving.

## Subscription Lookup

```php
$subscription = $xero->appStore()
    ->subscriptions()
    ->find('subscription-id');
```

## Usage Records

```php
$usageRecords = $subscription?->usageRecords();
```

```php
$usage = $subscription?->recordUsage()
    ->item('subscription-item-id')
    ->quantity(12)
    ->startDate('2026-03-01')
    ->endDate('2026-03-31')
    ->save();
```

```php
$updated = $xero->appStore()
    ->subscriptions()
    ->updateUsage('subscription-id', 'usage-record-id')
    ->item('subscription-item-id')
    ->quantity(15)
    ->startDate('2026-03-01')
    ->endDate('2026-03-31')
    ->save();
```

## Scope Notes

The current App Store slice uses granular `marketplace.billing`.
