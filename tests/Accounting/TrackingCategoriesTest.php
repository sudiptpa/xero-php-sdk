<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\TrackingCategory\TrackingCategory;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class TrackingCategoriesTest extends TestCase
{
    public function test_it_can_query_and_find_tracking_categories(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'TrackingCategories' => [[
                'TrackingCategoryID' => 'tracking-1',
                'Name' => 'Region',
                'Status' => 'ACTIVE',
                'Options' => [['Name' => 'APAC']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'TrackingCategories' => [[
                'TrackingCategoryID' => 'tracking-1',
                'Name' => 'Region',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $categories = $client->accounting()->trackingCategories()
            ->where('Status == :status', status: 'ACTIVE')
            ->includeArchived()
            ->get();
        $category = $client->accounting()->trackingCategories()->find('tracking-1');

        self::assertSame('/api.xro/2.0/TrackingCategories', $transport->requests()[0]->path);
        self::assertSame('true', $transport->requests()[0]->query['includeArchived']);
        self::assertInstanceOf(TrackingCategory::class, $categories->first());
        self::assertSame('/api.xro/2.0/TrackingCategories/tracking-1', $transport->requests()[1]->path);
        self::assertSame('tracking-1', $category?->id);
    }

    public function test_it_can_create_and_update_tracking_categories(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'TrackingCategories' => [[
                'TrackingCategoryID' => 'tracking-1',
                'Name' => 'Region',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'TrackingCategories' => [[
                'TrackingCategoryID' => 'tracking-1',
                'Name' => 'Sales Region',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->trackingCategories()->create()
            ->name('Region')
            ->idempotencyKey('tracking-key')
            ->save();

        $updated = $created->name('Sales Region')->save();

        self::assertSame('/api.xro/2.0/TrackingCategories', $transport->requests()[0]->path);
        self::assertSame('tracking-key', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame('Region', $transport->requests()[0]->json['Name']);
        self::assertSame('/api.xro/2.0/TrackingCategories/tracking-1', $transport->requests()[1]->path);
        self::assertSame('Sales Region', $updated->name);
    }
}
