<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\AppStore;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\AppStore\Subscription\Subscription;
use Sujip\Xero\AppStore\Subscription\UsageRecord;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Xero;

final class AppStoreTest extends TestCase
{
    public function test_it_exposes_marketplace_billing_scopes(): void
    {
        $client = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-1');

        $appStore = $client->appStore();
        $subscriptions = $appStore->subscriptions();

        self::assertSame(['marketplace.billing'], $appStore->scopes()->granular);
        self::assertSame([], $appStore->scopes()->broad);
        self::assertSame(['marketplace.billing'], $subscriptions->scopes()->granular);
    }

    public function test_subscription_getters_return_filled_values(): void
    {
        $subscription = (new Subscription())
            ->setId('subscription-1')
            ->setOrganisationId('org-1')
            ->setStatus('ACTIVE')
            ->setStartDate('2026-01-01')
            ->setCurrentPeriodEnd('2026-04-30')
            ->setEndDate('2026-12-31')
            ->setTestMode(true);

        self::assertSame('subscription-1', $subscription->getId());
        self::assertSame('org-1', $subscription->getOrganisationId());
        self::assertSame('ACTIVE', $subscription->getStatus());
        self::assertSame('2026-01-01', $subscription->getStartDate());
        self::assertSame('2026-04-30', $subscription->getCurrentPeriodEnd());
        self::assertSame('2026-12-31', $subscription->getEndDate());
        self::assertTrue($subscription->getTestMode());
    }

    public function test_usage_record_getters_return_filled_values(): void
    {
        $record = (new UsageRecord())
            ->setUsageRecordId('usage-1')
            ->setSubscriptionId('subscription-1')
            ->setSubscriptionItemId('item-1')
            ->setProductId('product-1')
            ->setPricePerUnit(0.1)
            ->setQuantity(22)
            ->setTestMode(true)
            ->setRecordedAt('2026-03-01T00:00:00');

        self::assertSame('usage-1', $record->getUsageRecordId());
        self::assertSame('subscription-1', $record->getSubscriptionId());
        self::assertSame('item-1', $record->getSubscriptionItemId());
        self::assertSame('product-1', $record->getProductId());
        self::assertSame(0.1, $record->getPricePerUnit());
        self::assertSame(22, $record->getQuantity());
        self::assertTrue($record->getTestMode());
        self::assertSame('2026-03-01T00:00:00', $record->getRecordedAt());
    }

    public function test_usage_records_require_a_bound_client_context(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot load usage records without a bound client context and subscription id.');

        (new Subscription())->usageRecords();
    }

    public function test_record_usage_requires_a_bound_client_context(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Cannot record usage without a bound client context and subscription id.');

        (new Subscription())->recordUsage();
    }

    public function test_recording_usage_requires_a_subscription_item_id(): void
    {
        $client = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-1');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('A subscription item id is required when recording or updating usage.');

        $client->appStore()->subscriptions()
            ->recordUsage('subscription-1')
            ->quantity(5)
            ->save();
    }
}
