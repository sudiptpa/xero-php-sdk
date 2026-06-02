<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
        $firstCat = $categories->first();
        self::assertNotNull($firstCat);
        self::assertSame('/api.xro/2.0/TrackingCategories/tracking-1', $transport->requests()[1]->path);
        self::assertSame('tracking-1', $category?->getTrackingCategoryID());
        self::assertSame('APAC', $firstCat->getOptions()[0]->getName());
        self::assertSame('APAC', $firstCat->getOptions()[0]->getName());
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
            ->option('APAC')
            ->idempotencyKey('tracking-key')
            ->save();

        $updated = $created->name('Sales Region')->save();

        self::assertSame('/api.xro/2.0/TrackingCategories', $transport->requests()[0]->path);
        self::assertSame('tracking-key', $transport->requests()[0]->headers['Idempotency-Key']);
        $json0 = $transport->requests()[0]->json ?? [];
        self::assertSame('Region', $json0['Name'] ?? null);
        $options0 = Json::extractList($json0, 'Options');
        self::assertSame('APAC', $options0[0]['Name'] ?? null);
        self::assertSame('/api.xro/2.0/TrackingCategories/tracking-1', $transport->requests()[1]->path);
        self::assertSame('Sales Region', $updated->getName());
    }
}
