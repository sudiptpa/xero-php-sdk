<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Accounting\Item\Item;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
                'InventoryAssetAccountCode' => '630',
                'IsPurchased' => true,
                'IsSold' => true,
                'IsTrackedAsInventory' => true,
                'PurchaseDescription' => 'Buy widget',
                'PurchaseDetails' => [
                    'UnitPrice' => 10.5,
                    'AccountCode' => '500',
                    'COGSAccountCode' => '310',
                    'TaxType' => 'INPUT2',
                ],
                'SalesDetails' => [
                    'UnitPrice' => 20.5,
                    'AccountCode' => '200',
                    'TaxType' => 'OUTPUT2',
                ],
                'QuantityOnHand' => 15,
                'QuantityAvailable' => 12,
                'QuantityOnBackOrder' => 0,
                'TotalCostPool' => 157.5,
                'StatusAttributeString' => 'ERROR',
                'UpdatedDateUTC' => '2026-04-01T01:00:00',
                'ValidationErrors' => [['Message' => 'Bad item']],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $items = $client->accounting()->items()->where('Code == :code', code: 'ABC123')->unitDp(4)->get();
        $item = $client->accounting()->items()->find('item-1');

        self::assertSame('/api.xro/2.0/Items', $transport->requests()[0]->path);
        self::assertSame('Code == "ABC123"', $transport->requests()[0]->query['where']);
        self::assertSame(4, $transport->requests()[0]->query['unitdp']);
        self::assertNotNull($items->first());
        self::assertSame('/api.xro/2.0/Items/item-1', $transport->requests()[1]->path);
        self::assertNotNull($item);
        self::assertSame('item-1', $item->getItemID());
        self::assertSame('630', $item->getInventoryAssetAccountCode());
        self::assertTrue($item->getIsPurchased());
        self::assertTrue($item->getIsSold());
        self::assertTrue($item->getIsTrackedAsInventory());
        self::assertSame('Buy widget', $item->getPurchaseDescription());
        self::assertNotNull($item->getPurchaseDetails());
        self::assertSame(10.5, $item->getPurchaseDetails()->getUnitPrice());
        self::assertSame('500', $item->getPurchaseDetails()->getAccountCode());
        self::assertSame('310', $item->getPurchaseDetails()->getCOGSAccountCode());
        self::assertSame('INPUT2', $item->getPurchaseDetails()->getTaxType());
        self::assertNotNull($item->getSalesDetails());
        self::assertSame(20.5, $item->getSalesDetails()->getUnitPrice());
        self::assertSame('200', $item->getSalesDetails()->getAccountCode());
        self::assertSame('OUTPUT2', $item->getSalesDetails()->getTaxType());
        self::assertSame(15, $item->getQuantityOnHand());
        self::assertSame(12, $item->getQuantityAvailable());
        self::assertSame(0, $item->getQuantityOnBackOrder());
        self::assertSame(157.5, $item->getTotalCostPool());
        self::assertSame('ERROR', $item->getStatusAttributeString());
        self::assertSame('2026-04-01T01:00:00', $item->getUpdatedDateUTC());
        self::assertCount(1, $item->getValidationErrors());
        self::assertSame('Bad item', $item->getValidationErrors()[0]->getMessage());
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
                    ->setInventoryAssetAccountCode('630')
                    ->setIsPurchased(true)
                    ->setIsSold(true)
                    ->setIsTrackedAsInventory(true)
                    ->setPurchaseDescription('Buy widget')
                    ->setPurchaseDetails(
                        (new \Sujip\Xero\Accounting\Item\Purchase())
                            ->setUnitPrice(10.5)
                            ->setAccountCode('500')
                            ->setCOGSAccountCode('310')
                            ->setTaxType('INPUT2')
                    )
                    ->setSalesDetails(
                        (new \Sujip\Xero\Accounting\Item\Purchase())
                            ->setUnitPrice(20.5)
                            ->setAccountCode('200')
                            ->setTaxType('OUTPUT2')
                    )
            )
            ->idempotencyKey('item-key')
            ->save();

        $updated = $created->name('Widget Plus')->description('Updated widget')->save();

        self::assertSame('/api.xro/2.0/Items', $transport->requests()[0]->path);
        self::assertSame('item-key', $transport->requests()[0]->headers['Idempotency-Key']);
        $json0 = $transport->requests()[0]->json ?? [];
        $item0 = Json::extractFirst($json0, 'Items');
        self::assertNotNull($item0);
        self::assertSame('ABC123', $item0['Code']);
        self::assertSame('630', $item0['InventoryAssetAccountCode']);
        self::assertTrue($item0['IsPurchased']);
        self::assertTrue($item0['IsSold']);
        self::assertTrue($item0['IsTrackedAsInventory']);
        self::assertSame('Buy widget', $item0['PurchaseDescription']);
        self::assertSame(10.5, Json::extractObject($item0, 'PurchaseDetails')['UnitPrice']);
        self::assertSame('310', Json::extractObject($item0, 'PurchaseDetails')['COGSAccountCode']);
        self::assertSame(20.5, Json::extractObject($item0, 'SalesDetails')['UnitPrice']);
        $json1 = $transport->requests()[1]->json ?? [];
        $item1 = Json::extractFirst($json1, 'Items');
        self::assertNotNull($item1);
        self::assertSame('/api.xro/2.0/Items', $transport->requests()[1]->path);
        self::assertSame('item-1', $item1['ItemID']);
        self::assertSame('Widget Plus', $updated->getName());
    }

    public function test_it_paginates_updates_and_builds_items(): void
    {
        $body = json_encode([
            'Items' => [[
                'ItemID' => 'item-1',
                'Code' => 'ABC123',
                'Name' => 'Widget',
                'Description' => 'Standard widget',
            ]],
        ], JSON_THROW_ON_ERROR);

        $transport = new FakeTransport();
        $transport->push(new Response(200, body: $body));
        $transport->push(new Response(200, body: $body));

        $items = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->items();

        $page = $items->paginate(2, 25);
        $updated = $items->update('item-1')
            ->code('ABC999')
            ->name('Widget Pro')
            ->description('Pro widget')
            ->save();

        self::assertSame('/api.xro/2.0/Items', $transport->requests()[0]->path);
        self::assertNotNull($page->items->first());
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
        self::assertSame('/api.xro/2.0/Items', $transport->requests()[1]->path);
        $json = $transport->requests()[1]->json ?? [];
        $sent = Json::extractFirst($json, 'Items');
        self::assertNotNull($sent);
        self::assertSame('item-1', $sent['ItemID']);
        self::assertSame('ABC999', $sent['Code']);
        self::assertSame('Widget', $updated->getName());
        self::assertNotSame([], $items->scopes()->broad);

        self::assertSame('XYZ', (new Item())->code('XYZ')->getCode());
        // history() returns a History accessor (its return type guarantees the class); call it for coverage.
        $updated->history();
    }

    public function test_item_model_guards_require_a_bound_client(): void
    {
        $this->expectException(RuntimeException::class);

        (new Item())->code('ABC')->save();
    }

    public function test_item_history_requires_a_client_and_id(): void
    {
        $this->expectException(RuntimeException::class);

        (new Item())->history();
    }
}
