<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class SettingsTest extends TestCase
{
    public function test_it_can_get_payroll_au_settings(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Settings' => [
                'EmployeeGroups' => [],
                'TrackingCategories' => [],
            ],
        ], JSON_THROW_ON_ERROR)));

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->settings()
            ->get();

        self::assertSame('/payroll.xro/1.0/Settings', $transport->requests()[0]->path);
        $settingsObj = Json::extractObject($settings, 'Settings');
        self::assertSame([], $settingsObj['EmployeeGroups'] ?? null);
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->settings()
            ->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }
}
