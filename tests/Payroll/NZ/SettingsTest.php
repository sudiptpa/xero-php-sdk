<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\Settings\PayrollSettings;
use Sujip\Xero\Payroll\NZ\Settings\StatutoryDeduction;
use Sujip\Xero\Xero;

final class SettingsTest extends TestCase
{
    public function test_it_can_get_payroll_nz_settings_and_statutory_deductions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'settings' => [
                'accounts' => [
                    ['accountID' => 'account-1', 'type' => 'WAGESPAYABLE', 'code' => '814', 'name' => 'Wages Payable'],
                ],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'trackingCategories' => [
                'employeeGroupsTrackingCategoryID' => 'tracking-1',
                'timesheetTrackingCategoryID' => 'tracking-2',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'statutoryDeductions' => [[
                'id' => 'deduction-1',
                'name' => 'KiwiSaver',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'statutoryDeduction' => [
                'id' => 'deduction-1',
                'name' => 'KiwiSaver',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->settings();

        $settings = $client->get();
        $trackingCategories = $client->trackingCategories();
        $deductions = $client->statutoryDeductions(page: 2);
        $deduction = $client->statutoryDeduction('deduction-1');

        self::assertSame('/payroll.xro/2.0/Settings', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/2.0/Settings/TrackingCategories', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/StatutoryDeductions', $transport->requests()[2]->path);
        self::assertSame(2, $transport->requests()[2]->query['page']);
        self::assertSame('/payroll.xro/2.0/StatutoryDeductions/deduction-1', $transport->requests()[3]->path);
        self::assertSame('account-1', $settings->getAccounts()[0]['accountID'] ?? null);
        self::assertSame('tracking-1', $trackingCategories['employeeGroupsTrackingCategoryID'] ?? null);
        $firstDed = $deductions->first();
        self::assertNotNull($firstDed);
        self::assertSame('KiwiSaver', $firstDed->getName());
        self::assertSame('deduction-1', $deduction?->getId());
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->settings()
            ->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }

    public function test_it_returns_blank_settings_when_response_has_no_settings_object(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->settings()
            ->get();

        self::assertSame([], $settings->getAccounts());
    }

    public function test_payroll_settings_expose_all_fields(): void
    {
        $settings = (new PayrollSettings())->fill([
            'accounts' => [['accountID' => 'account-1', 'type' => 'WAGESPAYABLE']],
        ]);

        self::assertSame('account-1', $settings->getAccounts()[0]['accountID'] ?? null);
    }

    public function test_statutory_deduction_exposes_all_fields(): void
    {
        $deduction = (new StatutoryDeduction())->fill([
            'id' => 'deduction-1',
            'name' => 'KiwiSaver',
            'statutoryDeductionCategory' => 'KiwiSaver',
            'liabilityAccountId' => 'account-9',
            'currentRecord' => true,
        ]);

        self::assertSame('deduction-1', $deduction->getId());
        self::assertSame('KiwiSaver', $deduction->getName());
        self::assertSame('KiwiSaver', $deduction->getStatutoryDeductionCategory());
        self::assertSame('account-9', $deduction->getLiabilityAccountId());
        self::assertTrue($deduction->getCurrentRecord());
    }
}
