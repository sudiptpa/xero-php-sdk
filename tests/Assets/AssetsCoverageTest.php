<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Assets;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Assets\Asset\Asset;
use Sujip\Xero\Assets\Asset\BookDepreciationDetail;
use Sujip\Xero\Assets\Asset\BookDepreciationSetting;
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

        $withBookDepreciation = (new Asset())->fill([
            'assetId' => 'asset-3',
            'bookDepreciationSetting' => [
                'depreciationMethod' => 'DiminishingValue100',
                'averagingMethod' => 'FullMonth',
                'depreciationRate' => 20.5,
                'effectiveLifeYears' => 5.5,
                'depreciationCalculationMethod' => 'Rate',
                'depreciableObjectId' => 'object-1',
                'depreciableObjectType' => 'Asset',
                'bookEffectiveDateOfChangeId' => 'change-1',
            ],
            'bookDepreciationDetail' => [
                'currentCapitalGain' => 10.5,
                'currentGainLoss' => 20.5,
                'depreciationStartDate' => '2026-01-01',
                'costLimit' => 100.5,
                'residualValue' => 5.5,
                'priorAccumDepreciationAmount' => 15.5,
                'currentAccumDepreciationAmount' => 25.5,
                'businessUseCapitalGain' => 1.5,
                'businessUseCurrentGainLoss' => 2.5,
                'privateUseCapitalGain' => 3.5,
                'privateUseCurrentGainLoss' => 4.5,
                'initialDeductionPercentage' => 50.5,
            ],
        ]);

        $bookSetting = $withBookDepreciation->getBookDepreciationSetting();
        $bookDetail = $withBookDepreciation->getBookDepreciationDetail();
        self::assertNotNull($bookSetting);
        self::assertNotNull($bookDetail);

        self::assertSame('DiminishingValue100', $bookSetting->getDepreciationMethod());
        self::assertSame('FullMonth', $bookSetting->getAveragingMethod());
        self::assertSame(20.5, $bookSetting->getDepreciationRate());
        self::assertSame(5.5, $bookSetting->getEffectiveLifeYears());
        self::assertSame('Rate', $bookSetting->getDepreciationCalculationMethod());
        self::assertSame('object-1', $bookSetting->getDepreciableObjectId());
        self::assertSame('Asset', $bookSetting->getDepreciableObjectType());
        self::assertSame('change-1', $bookSetting->getBookEffectiveDateOfChangeId());

        self::assertSame(10.5, $bookDetail->getCurrentCapitalGain());
        self::assertSame(20.5, $bookDetail->getCurrentGainLoss());
        self::assertSame('2026-01-01', $bookDetail->getDepreciationStartDate());
        self::assertSame(100.5, $bookDetail->getCostLimit());
        self::assertSame(5.5, $bookDetail->getResidualValue());
        self::assertSame(15.5, $bookDetail->getPriorAccumDepreciationAmount());
        self::assertSame(25.5, $bookDetail->getCurrentAccumDepreciationAmount());
        self::assertSame(1.5, $bookDetail->getBusinessUseCapitalGain());
        self::assertSame(2.5, $bookDetail->getBusinessUseCurrentGainLoss());
        self::assertSame(3.5, $bookDetail->getPrivateUseCapitalGain());
        self::assertSame(4.5, $bookDetail->getPrivateUseCurrentGainLoss());
        self::assertSame(50.5, $bookDetail->getInitialDeductionPercentage());
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

    public function test_asset_disposal_warranty_and_book_depreciation_getters_and_setters(): void
    {
        $detail = (new BookDepreciationDetail())
            ->setCurrentCapitalGain(10.5)
            ->setCurrentGainLoss(20.5)
            ->setDepreciationStartDate('2026-01-01')
            ->setCostLimit(100.5)
            ->setResidualValue(5.5)
            ->setPriorAccumDepreciationAmount(15.5)
            ->setCurrentAccumDepreciationAmount(25.5)
            ->setBusinessUseCapitalGain(1.5)
            ->setBusinessUseCurrentGainLoss(2.5)
            ->setPrivateUseCapitalGain(3.5)
            ->setPrivateUseCurrentGainLoss(4.5)
            ->setInitialDeductionPercentage(50.5);

        self::assertSame(10.5, $detail->getCurrentCapitalGain());
        self::assertSame(20.5, $detail->getCurrentGainLoss());
        self::assertSame('2026-01-01', $detail->getDepreciationStartDate());
        self::assertSame(100.5, $detail->getCostLimit());
        self::assertSame(5.5, $detail->getResidualValue());
        self::assertSame(15.5, $detail->getPriorAccumDepreciationAmount());
        self::assertSame(25.5, $detail->getCurrentAccumDepreciationAmount());
        self::assertSame(1.5, $detail->getBusinessUseCapitalGain());
        self::assertSame(2.5, $detail->getBusinessUseCurrentGainLoss());
        self::assertSame(3.5, $detail->getPrivateUseCapitalGain());
        self::assertSame(4.5, $detail->getPrivateUseCurrentGainLoss());
        self::assertSame(50.5, $detail->getInitialDeductionPercentage());

        $setting = (new BookDepreciationSetting())
            ->setDepreciationMethod('DiminishingValue100')
            ->setAveragingMethod('FullMonth')
            ->setDepreciationRate(20.5)
            ->setEffectiveLifeYears(5.5)
            ->setDepreciationCalculationMethod('Rate')
            ->setDepreciableObjectId('object-1')
            ->setDepreciableObjectType('Asset')
            ->setBookEffectiveDateOfChangeId('change-1');

        self::assertSame('DiminishingValue100', $setting->getDepreciationMethod());
        self::assertSame('FullMonth', $setting->getAveragingMethod());
        self::assertSame(20.5, $setting->getDepreciationRate());
        self::assertSame(5.5, $setting->getEffectiveLifeYears());
        self::assertSame('Rate', $setting->getDepreciationCalculationMethod());
        self::assertSame('object-1', $setting->getDepreciableObjectId());
        self::assertSame('Asset', $setting->getDepreciableObjectType());
        self::assertSame('change-1', $setting->getBookEffectiveDateOfChangeId());

        $asset = (new Asset())
            ->setPurchaseDate('2024-01-01')
            ->setPurchasePrice(1500.5)
            ->setDisposalDate('2026-01-01')
            ->setDisposalPrice(500.5)
            ->setWarrantyExpiryDate('2027-01-01')
            ->setSerialNumber('SN-123')
            ->setBookDepreciationSetting($setting)
            ->setBookDepreciationDetail($detail)
            ->setCanRollback(true)
            ->setAccountingBookValue(999.5)
            ->setIsDeleteEnabledForDate(false);

        self::assertSame('2024-01-01', $asset->getPurchaseDate());
        self::assertSame(1500.5, $asset->getPurchasePrice());
        self::assertSame('2026-01-01', $asset->getDisposalDate());
        self::assertSame(500.5, $asset->getDisposalPrice());
        self::assertSame('2027-01-01', $asset->getWarrantyExpiryDate());
        self::assertSame('SN-123', $asset->getSerialNumber());
        self::assertSame($setting, $asset->getBookDepreciationSetting());
        self::assertSame($detail, $asset->getBookDepreciationDetail());
        self::assertTrue($asset->getCanRollback());
        self::assertSame(999.5, $asset->getAccountingBookValue());
        self::assertFalse($asset->getIsDeleteEnabledForDate());
    }

    public function test_type_getters_and_setters(): void
    {
        $setting = (new BookDepreciationSetting())->setDepreciationMethod('DiminishingValue100');

        $type = (new Type())
            ->setAssetTypeId('type-1')
            ->setFixedAssetAccountId('account-1')
            ->setDepreciationExpenseAccountId('account-2')
            ->setAccumulatedDepreciationAccountId('account-3')
            ->setLocks(2)
            ->setBookDepreciationSetting($setting);

        self::assertSame('type-1', $type->getAssetTypeId());
        self::assertSame('account-1', $type->getFixedAssetAccountId());
        self::assertSame('account-2', $type->getDepreciationExpenseAccountId());
        self::assertSame('account-3', $type->getAccumulatedDepreciationAccountId());
        self::assertSame(2, $type->getLocks());
        self::assertSame($setting, $type->getBookDepreciationSetting());
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
