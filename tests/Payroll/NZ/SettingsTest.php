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
        self::assertInstanceOf(PayrollSettings::class, $settings);
        self::assertSame([], $settings->getAccounts());
        self::assertInstanceOf(StatutoryDeduction::class, $deductions->first());
        self::assertSame('KiwiSaver', $deductions->first()->getName());
        self::assertSame('deduction-1', $deduction?->getStatutoryDeductionID());
    }
}
