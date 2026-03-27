<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Assets;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Assets\Asset\Asset;
use Sujip\Xero\Assets\Settings\Settings;
use Sujip\Xero\Assets\Type\Type;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class AssetsTest extends TestCase
{
    public function test_it_can_query_list_paginate_and_find_assets(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'AssetId' => 'asset-1',
                'AssetName' => 'MacBook Pro',
                'AssetNumber' => 'FA-1001',
                'Status' => 'DRAFT',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'AssetId' => 'asset-1',
                'AssetName' => 'MacBook Pro',
                'AssetNumber' => 'FA-1001',
                'Status' => 'REGISTERED',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'AssetId' => 'asset-1',
                'AssetName' => 'MacBook Pro',
                'AssetNumber' => 'FA-1001',
                'Status' => 'REGISTERED',
            ]],
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
        self::assertInstanceOf(Asset::class, $assets->first());
        self::assertSame(3, $paginated->page);
        self::assertSame(10, $paginated->perPage);
        self::assertSame('/assets.xro/1.0/Assets/asset-1', $transport->requests()[2]->path);
        self::assertSame('REGISTERED', $asset?->status);
    }

    public function test_it_can_create_an_asset(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Items' => [[
                    'AssetId' => 'asset-1',
                    'AssetName' => 'MacBook Pro',
                    'AssetNumber' => 'FA-1001',
                    'Status' => 'DRAFT',
                    'AssetTypeId' => 'type-1',
                ]],
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
        self::assertSame('MacBook Pro', $request->json['AssetName']);
        self::assertSame('DRAFT', $request->json['Status']);
        self::assertSame('asset-key', $request->headers['Idempotency-Key']);
        self::assertSame('type-1', $asset->assetTypeId);
    }

    public function test_it_can_list_asset_types_from_both_entrypoints_and_create_asset_types(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'AssetTypeId' => 'type-1',
                'AssetTypeName' => 'Computer Equipment',
                'FixedAssetAccountId' => 'account-1',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'AssetTypeId' => 'type-2',
                'AssetTypeName' => 'Office Equipment',
                'FixedAssetAccountId' => 'account-2',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'AssetTypeId' => 'type-2',
                'AssetTypeName' => 'Office Equipment',
                'FixedAssetAccountId' => 'account-2',
            ]],
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
        self::assertInstanceOf(Type::class, $types->first());
        self::assertInstanceOf(Type::class, $typesFromRoot->first());
        self::assertSame('/assets.xro/1.0/AssetTypes', $transport->requests()[1]->path);
        self::assertSame('/assets.xro/1.0/AssetTypes', $transport->requests()[2]->path);
        self::assertSame('Office Equipment', $transport->requests()[2]->json['AssetTypeName']);
        self::assertSame('type-key', $transport->requests()[2]->headers['Idempotency-Key']);
        self::assertSame('Office Equipment', $created->name);
    }

    public function test_it_can_fetch_asset_settings(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Items' => [[
                    'DepreciationCalculationEnabled' => true,
                    'DefaultGainOnDisposalAccountId' => 'account-1',
                    'DefaultLossOnDisposalAccountId' => 'account-2',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->assets()
            ->settings();

        self::assertSame('/assets.xro/1.0/Settings', $transport->requests()[0]->path);
        self::assertInstanceOf(Settings::class, $settings);
        self::assertTrue((bool) $settings->depreciationCalculationEnabled);
    }
}
