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

final class AssetsCoverageTest extends TestCase
{
    public function test_assets_entrypoint_exposes_scopes_and_client(): void
    {
        $client = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-1');

        $assets = $client->assets();

        self::assertSame(['assets'], $assets->scopes()->broad);
        self::assertSame(['assets.read', 'assets'], $assets->scopes()->granular);
        self::assertSame($client, $assets->client());
        self::assertSame(['assets'], $client->assets()->assetTypes()->scopes()->broad);
    }

    public function test_asset_getters_and_nested_asset_type_hydration(): void
    {
        $asset = (new Asset())
            ->setAssetId('asset-1')
            ->setAssetName('MacBook Pro')
            ->setAssetNumber('FA-1001');

        self::assertSame('asset-1', $asset->getAssetId());
        self::assertSame('MacBook Pro', $asset->getAssetName());
        self::assertSame('FA-1001', $asset->getAssetNumber());

        $hydrated = (new Asset())->fill([
            'assetId' => 'asset-2',
            'assetTypeId' => 'type-9',
        ]);

        self::assertSame('type-9', $hydrated->getAssetTypeId());
    }

    public function test_creating_an_asset_without_idempotency_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $asset = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-1')
            ->assets()
            ->create()
            ->name('Server')
            ->warrantyExpiryDate('2030-01-01')
            ->save();

        $request = $transport->requests()[0];

        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertSame('2030-01-01', $request->json['warrantyExpiryDate'] ?? null);
        self::assertNull($asset->getAssetId());
    }

    public function test_settings_getters_and_fetch(): void
    {
        $settings = (new Settings())
            ->setDefaultGainOnDisposalAccountId('gain-1')
            ->setDefaultLossOnDisposalAccountId('loss-1')
            ->setDefaultCapitalGainOnDisposalAccountId('capital-1')
            ->setAssetNumberPrefix('FA-')
            ->setAssetNumberSequence('0007')
            ->setAssetStartDate('2016-01-01')
            ->setLastDepreciationDate('2016-01-01')
            ->setOptInForTax(true);

        self::assertSame('gain-1', $settings->getDefaultGainOnDisposalAccountId());
        self::assertSame('loss-1', $settings->getDefaultLossOnDisposalAccountId());
        self::assertSame('capital-1', $settings->getDefaultCapitalGainOnDisposalAccountId());
        self::assertSame('FA-', $settings->getAssetNumberPrefix());
        self::assertSame('0007', $settings->getAssetNumberSequence());
        self::assertSame('2016-01-01', $settings->getAssetStartDate());
        self::assertSame('2016-01-01', $settings->getLastDepreciationDate());
        self::assertTrue($settings->getOptInForTax());

        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $fetched = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-1')
            ->assets()
            ->settings();

        self::assertNull($fetched->getAssetNumberPrefix());
    }

    public function test_type_getters_and_setters(): void
    {
        $type = (new Type())
            ->setAssetTypeId('type-1')
            ->setFixedAssetAccountId('account-1')
            ->setDepreciationExpenseAccountId('account-2')
            ->setAccumulatedDepreciationAccountId('account-3')
            ->setLocks(2);

        self::assertSame('type-1', $type->getAssetTypeId());
        self::assertSame('account-1', $type->getFixedAssetAccountId());
        self::assertSame('account-2', $type->getDepreciationExpenseAccountId());
        self::assertSame('account-3', $type->getAccumulatedDepreciationAccountId());
        self::assertSame(2, $type->getLocks());
    }

    public function test_creating_an_asset_type_without_idempotency_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $type = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-1')
            ->assets()
            ->createAssetType()
            ->name('Vehicles')
            ->depreciationMethod('DiminishingValue100')
            ->save();

        $request = $transport->requests()[0];

        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        $bookSetting = $request->json['bookDepreciationSetting'] ?? [];
        self::assertIsArray($bookSetting);
        self::assertSame('DiminishingValue100', $bookSetting['depreciationMethod'] ?? null);
        self::assertNull($type->getAssetTypeId());
    }
}
