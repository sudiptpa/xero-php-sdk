<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\AppStore;

use PHPUnit\Framework\TestCase;
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
            'planId' => 'plan-1',
            'status' => 'ACTIVE',
            'currentPeriodEnd' => '2026-04-30',
            'items' => [[
                'id' => 'item-1',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'items' => [[
                'id' => 'usage-1',
                'subscriptionItemId' => 'item-1',
                'quantity' => 10,
                'startDate' => '2026-03-01',
                'endDate' => '2026-03-31',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'id' => 'usage-2',
            'subscriptionItemId' => 'item-1',
            'quantity' => 12,
            'startDate' => '2026-03-01',
            'endDate' => '2026-03-31',
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'id' => 'usage-2',
            'subscriptionItemId' => 'item-1',
            'quantity' => 15,
            'startDate' => '2026-03-01',
            'endDate' => '2026-03-31',
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $subscription = $client->appStore()->subscriptions()->find('subscription-1');
        $usageRecords = $subscription->usageRecords();
        $recorded = $subscription->recordUsage()
            ->item('item-1')
            ->quantity(12)
            ->startDate('2026-03-01')
            ->endDate('2026-03-31')
            ->save();
        $updated = $client->appStore()->subscriptions()->updateUsage('subscription-1', 'usage-2')
            ->item('item-1')
            ->quantity(15)
            ->startDate('2026-03-01')
            ->endDate('2026-03-31')
            ->save();

        $items = $subscription->getItems();
        self::assertSame('item-1', $items[0]['id'] ?? null);
        self::assertSame('/subscriptions/subscription-1', $transport->requests()[0]->path);
        self::assertFalse($transport->requests()[0]->includeTenantHeader);
        self::assertSame('/subscriptions/subscription-1/usage-records', $transport->requests()[1]->path);
        self::assertFalse($transport->requests()[1]->includeTenantHeader);
        self::assertSame('/subscriptions/subscription-1/items/item-1/usage-records', $transport->requests()[2]->path);
        self::assertSame('/subscriptions/subscription-1/items/item-1/usage-records/usage-2', $transport->requests()[3]->path);
        self::assertNotNull($usageRecords->first());
        self::assertSame('usage-2', $recorded->getUsageRecordID());
        self::assertSame(15.0, $updated->getQuantity());
    }
}
