<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Item\Item;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ItemsTest extends TestCase
{
    public function test_it_can_query_and_find_items(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'ItemID' => 'item-1',
                'Code' => 'ABC123',
                'Name' => 'Widget',
                'Description' => 'Standard widget',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'ItemID' => 'item-1',
                'Code' => 'ABC123',
                'Name' => 'Widget',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $items = $client->accounting()->items()->where('Code == :code', code: 'ABC123')->unitDp(4)->get();
        $item = $client->accounting()->items()->find('item-1');

        self::assertSame('/api.xro/2.0/Items', $transport->requests()[0]->path);
        self::assertSame('Code == "ABC123"', $transport->requests()[0]->query['where']);
        self::assertSame(4, $transport->requests()[0]->query['unitdp']);
        self::assertInstanceOf(Item::class, $items->first());
        self::assertSame('/api.xro/2.0/Items/item-1', $transport->requests()[1]->path);
        self::assertSame('item-1', $item?->getItemID());
    }

    public function test_it_can_create_and_update_items(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'ItemID' => 'item-1',
                'Code' => 'ABC123',
                'Name' => 'Widget',
                'Description' => 'Standard widget',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'ItemID' => 'item-1',
                'Code' => 'ABC123',
                'Name' => 'Widget Plus',
                'Description' => 'Updated widget',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->items()->create()
            ->using(
                (new Item())
                    ->setCode('ABC123')
                    ->setName('Widget')
                    ->setDescription('Standard widget')
            )
            ->idempotencyKey('item-key')
            ->save();

        $updated = $created->name('Widget Plus')->description('Updated widget')->save();

        self::assertSame('/api.xro/2.0/Items', $transport->requests()[0]->path);
        self::assertSame('item-key', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame('ABC123', $transport->requests()[0]->json['Items'][0]['Code']);
        self::assertSame('/api.xro/2.0/Items', $transport->requests()[1]->path);
        self::assertSame('item-1', $transport->requests()[1]->json['Items'][0]['ItemID']);
        self::assertSame('Widget Plus', $updated->getName());
    }
}
