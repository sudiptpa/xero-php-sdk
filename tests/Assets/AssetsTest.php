<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Assets;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class AssetsTest extends TestCase
{
    public function test_it_can_query_list_paginate_and_find_assets(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'pagination' => [
                'page' => 1,
                'pageSize' => 10,
                'pageCount' => 1,
                'itemCount' => 1,
            ],
            'items' => [[
                'assetId' => 'asset-1',
                'assetName' => 'MacBook Pro',
                'assetNumber' => 'FA-1001',
                'assetStatus' => 'Draft',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'pagination' => [
                'page' => 3,
                'pageSize' => 10,
                'pageCount' => 1,
                'itemCount' => 1,
            ],
            'items' => [[
                'assetId' => 'asset-1',
                'assetName' => 'MacBook Pro',
                'assetNumber' => 'FA-1001',
                'assetStatus' => 'Registered',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'assetId' => 'asset-1',
            'assetName' => 'MacBook Pro',
            'assetNumber' => 'FA-1001',
            'assetStatus' => 'Registered',
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $assets = $client->assets()
            ->status('registered')
            ->page(2)
            ->perPage(5)
            ->orderBy('AssetName', 'DESC')
            ->filterBy('MacBook')
            ->get();
        $paginated = $client->assets()
            ->status('registered')
            ->orderBy('AssetName')
            ->paginate(page: 3, perPage: 10);
        $asset = $client->assets()->find('asset-1');

        self::assertSame('/assets.xro/1.0/Assets', $transport->requests()[0]->path);
        self::assertSame('REGISTERED', $transport->requests()[0]->query['status']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(5, $transport->requests()[0]->query['pageSize']);
        self::assertSame('AssetName', $transport->requests()[0]->query['orderBy']);
        self::assertSame('DESC', $transport->requests()[0]->query['sortDirection']);
        self::assertSame('MacBook', $transport->requests()[0]->query['filterBy']);
        self::assertNotNull($assets->first());
        self::assertSame(3, $paginated->page);
        self::assertSame(10, $paginated->perPage);
        self::assertSame('/assets.xro/1.0/Assets/asset-1', $transport->requests()[2]->path);
        self::assertSame('Registered', $asset->getAssetStatus());
    }

    public function test_it_can_create_an_asset(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'assetId' => 'asset-1',
                'assetName' => 'MacBook Pro',
                'assetNumber' => 'FA-1001',
                'assetStatus' => 'Draft',
                'assetTypeId' => 'type-1',
            ], JSON_THROW_ON_ERROR))
        );

        $asset = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->assets()
            ->create()
            ->name('MacBook Pro')
            ->number('FA-1001')
            ->status('draft')
            ->assetType('type-1')
            ->purchaseDate('2026-03-25')
            ->purchasePrice(2400)
            ->serialNumber('SN-001')
            ->idempotencyKey('asset-key')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/assets.xro/1.0/Assets', $request->path);
        $json = $request->json ?? [];
        self::assertSame('MacBook Pro', $json['assetName'] ?? null);
        self::assertSame('Draft', $json['assetStatus'] ?? null);
        self::assertSame('asset-key', $request->headers['Idempotency-Key']);
        self::assertSame('type-1', $asset->getAssetTypeId());
    }

    public function test_it_can_list_asset_types_from_both_entrypoints_and_create_asset_types(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([[
            'assetTypeId' => 'type-1',
            'assetTypeName' => 'Computer Equipment',
            'fixedAssetAccountId' => 'account-1',
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([[
            'assetTypeId' => 'type-2',
            'assetTypeName' => 'Office Equipment',
            'fixedAssetAccountId' => 'account-2',
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'assetTypeId' => 'type-2',
            'assetTypeName' => 'Office Equipment',
            'fixedAssetAccountId' => 'account-2',
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $types = $client->assets()->assetTypes()->get();
        $typesFromRoot = $client->assets()->getAssetTypes();
        $created = $client->assets()
            ->createAssetType()
            ->name('Office Equipment')
            ->fixedAssetAccount('account-2')
            ->depreciationExpenseAccount('account-3')
            ->accumulatedDepreciationAccount('account-4')
            ->depreciationMethod('DiminishingValue100')
            ->averagingMethod('ActualDays')
            ->depreciationRate(40)
            ->depreciationCalculationMethod('None')
            ->idempotencyKey('type-key')
            ->save();

        self::assertSame('/assets.xro/1.0/AssetTypes', $transport->requests()[0]->path);
        self::assertNotNull($types->first());
        self::assertNotNull($typesFromRoot->first());
        self::assertSame('/assets.xro/1.0/AssetTypes', $transport->requests()[1]->path);
        self::assertSame('/assets.xro/1.0/AssetTypes', $transport->requests()[2]->path);
        $json2 = $transport->requests()[2]->json ?? [];
        self::assertSame('Office Equipment', $json2['assetTypeName'] ?? null);
        self::assertSame('type-key', $transport->requests()[2]->headers['Idempotency-Key']);
        self::assertSame('Office Equipment', $created->getAssetTypeName());
    }

    public function test_it_can_fetch_asset_settings(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'assetNumberPrefix' => 'FA-',
                'assetNumberSequence' => '0007',
                'optInForTax' => false,
                'defaultGainOnDisposalAccountId' => 'account-1',
                'defaultLossOnDisposalAccountId' => 'account-2',
            ], JSON_THROW_ON_ERROR))
        );

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->assets()
            ->settings();

        self::assertSame('/assets.xro/1.0/Settings', $transport->requests()[0]->path);
        self::assertSame('FA-', $settings->getAssetNumberPrefix());
        self::assertFalse($settings->getOptInForTax());
    }
}
