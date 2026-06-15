<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\AppStore;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\AppStore\Subscription\Plan;
use Sujip\Xero\AppStore\Subscription\Product;
use Sujip\Xero\AppStore\Subscription\Subscription;
use Sujip\Xero\AppStore\Subscription\SubscriptionItem;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class SubscriptionsTest extends TestCase
{
    public function test_it_can_find_subscriptions_and_manage_usage_records_without_a_tenant_header(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'id' => 'subscription-1',
            'organisationId' => 'org-1',
            'status' => 'ACTIVE',
            'startDate' => '2026-01-01',
            'currentPeriodEnd' => '2026-04-30',
            'testMode' => true,
            'plans' => [[
                'id' => 'plan-1',
                'name' => 'Small',
                'status' => 'ACTIVE',
                'subscriptionItems' => [[
                    'id' => 'item-1',
                    'startDate' => '2026-01-01',
                    'status' => 'ACTIVE',
                    'testMode' => true,
                    'quantity' => 1,
                    'price' => [
                        'id' => 'price-1',
                        'amount' => 50,
                        'currency' => 'AUD',
                    ],
                    'product' => [
                        'id' => 'product-1',
                        'name' => 'Small',
                        'type' => 'FIXED',
                    ],
                ]],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'usageRecords' => [[
                'usageRecordId' => 'usage-1',
                'subscriptionId' => 'subscription-1',
                'subscriptionItemId' => 'item-1',
                'productId' => 'product-1',
                'pricePerUnit' => 0.1,
                'quantity' => 10,
                'testMode' => true,
                'recordedAt' => '2026-03-01T00:00:00',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'usageRecordId' => 'usage-2',
            'subscriptionId' => 'subscription-1',
            'subscriptionItemId' => 'item-1',
            'productId' => 'product-1',
            'pricePerUnit' => 0.1,
            'quantity' => 12,
            'testMode' => true,
            'recordedAt' => '2026-03-01T00:00:00',
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'usageRecordId' => 'usage-2',
            'subscriptionId' => 'subscription-1',
            'subscriptionItemId' => 'item-1',
            'productId' => 'product-1',
            'pricePerUnit' => 0.1,
            'quantity' => 15,
            'testMode' => true,
            'recordedAt' => '2026-03-01T00:00:00',
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $subscription = $client->appStore()->subscriptions()->find('subscription-1');
        $usageRecords = $subscription->usageRecords();
        $recorded = $subscription->recordUsage()
            ->item('item-1')
            ->quantity(12)
            ->timestamp('2026-03-01T00:00:00')
            ->save();
        $updated = $client->appStore()->subscriptions()->updateUsage('subscription-1', 'usage-2')
            ->item('item-1')
            ->quantity(15)
            ->save();

        $plans = $subscription->getPlans();
        $item = $plans[0]->getSubscriptionItems()[0];
        $price = $item->getPrice();
        $product = $item->getProduct();
        self::assertNotNull($price);
        self::assertNotNull($product);
        self::assertSame('plan-1', $plans[0]->getId());
        self::assertSame('Small', $plans[0]->getName());
        self::assertSame('ACTIVE', $plans[0]->getStatus());
        self::assertSame('item-1', $item->getId());
        self::assertSame('2026-01-01', $item->getStartDate());
        self::assertSame('ACTIVE', $item->getStatus());
        self::assertTrue($item->getTestMode());
        self::assertSame(1, $item->getQuantity());
        self::assertSame('price-1', $price->getId());
        self::assertSame(50, $price->getAmount());
        self::assertSame('AUD', $price->getCurrency());
        self::assertSame('product-1', $product->getId());
        self::assertSame('Small', $product->getName());
        self::assertSame('FIXED', $product->getType());
        self::assertTrue($subscription->getTestMode());
        self::assertSame('org-1', $subscription->getOrganisationId());
        self::assertSame('/appstore/2.0/subscriptions/subscription-1', $transport->requests()[0]->path);
        self::assertFalse($transport->requests()[0]->includeTenantHeader);
        self::assertSame('/appstore/2.0/subscriptions/subscription-1/usage-records', $transport->requests()[1]->path);
        self::assertFalse($transport->requests()[1]->includeTenantHeader);
        self::assertSame('/appstore/2.0/subscriptions/subscription-1/items/item-1/usage-records', $transport->requests()[2]->path);
        self::assertSame('/appstore/2.0/subscriptions/subscription-1/items/item-1/usage-records/usage-2', $transport->requests()[3]->path);
        self::assertNotNull($usageRecords->first());
        self::assertSame('usage-2', $recorded->getUsageRecordId());
        self::assertSame(15, $updated->getQuantity());
    }

    public function test_subscription_value_objects_setters(): void
    {
        $item = (new SubscriptionItem())
            ->setEndDate('2026-12-31');
        self::assertSame('2026-12-31', $item->getEndDate());

        $product = (new Product())
            ->setSeatUnit('seats')
            ->setUsageUnit('units');
        self::assertSame('seats', $product->getSeatUnit());
        self::assertSame('units', $product->getUsageUnit());

        $plan = (new Plan())->setSubscriptionItems([$item]);
        self::assertSame([$item], $plan->getSubscriptionItems());

        $subscription = (new Subscription())->setPlans([$plan]);
        self::assertSame([$plan], $subscription->getPlans());
    }
}
