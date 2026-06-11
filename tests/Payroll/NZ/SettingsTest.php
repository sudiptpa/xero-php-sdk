<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\Settings\PayrollSettings;
use Sujip\Xero\Xero;

final class SettingsTest extends TestCase
{
    public function test_it_can_get_payroll_nz_settings_and_statutory_deductions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Settings' => [
                'Accounts' => [],
                'TrackingCategories' => [],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'StatutoryDeductions' => [[
                'StatutoryDeductionID' => 'deduction-1',
                'Name' => 'KiwiSaver',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'StatutoryDeduction' => [
                'StatutoryDeductionID' => 'deduction-1',
                'Name' => 'KiwiSaver',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->settings();

        $settings = $client
            ->get();
        $deductions = $client->statutoryDeductions(page: 2);
        $deduction = $client->statutoryDeduction('deduction-1');

        self::assertSame('/payroll.xro/2.0/Settings', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/2.0/StatutoryDeductions', $transport->requests()[1]->path);
        self::assertSame(2, $transport->requests()[1]->query['page']);
        self::assertSame('/payroll.xro/2.0/StatutoryDeductions/deduction-1', $transport->requests()[2]->path);
        self::assertSame([], $settings->getAccounts());
        $firstDed = $deductions->first();
        self::assertNotNull($firstDed);
        self::assertSame('KiwiSaver', $firstDed->getName());
        self::assertSame('deduction-1', $deduction?->getStatutoryDeductionID());
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
        self::assertSame([], $settings->getTrackingCategories());
    }

    public function test_payroll_settings_expose_all_fields(): void
    {
        $settings = (new PayrollSettings())->fill([
            'Accounts' => [['AccountID' => 'account-1', 'Type' => 'WAGESPAYABLE']],
            'TrackingCategories' => [['TrackingCategoryID' => 'tracking-1']],
        ]);

        self::assertSame('account-1', $settings->getAccounts()[0]['AccountID'] ?? null);
        self::assertSame('tracking-1', $settings->getTrackingCategories()[0]['TrackingCategoryID'] ?? null);
    }
}
