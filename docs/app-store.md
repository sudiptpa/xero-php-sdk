# App Store
Subscriptions and usage records.

Coverage:

- fetching subscriptions
- listing usage records
- creating usage records
- updating usage records

These requests are app-level rather than tenant-scoped, so the SDK does not send the Xero tenant header.

## Subscription Lookup

```php
$subscription = $xero->appStore()
    ->subscriptions()
    ->find('subscription-id');

$subscriptionId = $subscription->getSubscriptionID();
$planId = $subscription->getPlanID();
$status = $subscription->getStatus();
$items = $subscription->getItems();
```

## Usage Records

```php
$usageRecords = $subscription?->usageRecords();

$usageRecordId = $usageRecords->first()?->getUsageRecordID();
$quantity = $usageRecords->first()?->getQuantity();
```

```php
$usage = $subscription?->recordUsage()
    ->item('subscription-item-id')
    ->quantity(12)
    ->startDate('2026-03-01')
    ->endDate('2026-03-31')
    ->save();

$createdUsageId = $usage->getUsageRecordID();
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

$updatedQuantity = $updated->getQuantity();
```

## Scope Notes

The current App Store coverage uses granular `marketplace.billing`.
