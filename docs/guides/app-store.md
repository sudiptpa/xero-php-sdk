# App Store

Subscriptions and usage records.

These requests are app-level, not tenant-scoped. The SDK does not send the Xero tenant header for App Store calls.

## Get a subscription

```php
$subscription = $xero->appStore()
    ->subscriptions()
    ->find('subscription-id');

$subscriptionId = $subscription->getId();
$status = $subscription->getStatus();
$plans = $subscription->getPlans();
```

## Usage records

```php
$usageRecords = $subscription?->usageRecords();

$usageRecordId = $usageRecords->first()?->getUsageRecordId();
$quantity = $usageRecords->first()?->getQuantity();
```

```php
$usage = $subscription?->recordUsage()
    ->item('subscription-item-id')
    ->quantity(12)
    ->timestamp('2026-03-31T23:59:59Z')
    ->save();

$createdUsageId = $usage->getUsageRecordId();
```

```php
$updated = $xero->appStore()
    ->subscriptions()
    ->updateUsage('subscription-id', 'usage-record-id')
    ->quantity(15)
    ->save();

$updatedQuantity = $updated->getQuantity();
```

## Scopes

- `marketplace.billing`: access subscriptions and usage records
