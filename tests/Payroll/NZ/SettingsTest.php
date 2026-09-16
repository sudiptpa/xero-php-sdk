<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\Settings\PayrollSettings;
use Sujip\Xero\Payroll\NZ\Settings\Reimbursement;
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
        $transport->push(new Response(200, body: json_encode([
            'reimbursements' => [[
                'reimbursementID' => 'reimbursement-1',
                'name' => 'Mileage',
                'accountID' => 'account-2',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'reimbursement' => [
                'reimbursementID' => 'reimbursement-1',
                'name' => 'Mileage',
                'accountID' => 'account-2',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'reimbursement' => [
                'reimbursementID' => 'reimbursement-2',
                'name' => 'Meals',
                'accountID' => 'account-3',
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
        $reimbursements = $client->reimbursements();
        $reimbursement = $client->reimbursement('reimbursement-1');
        $created = $client->createReimbursement()
            ->name('Meals')
            ->account('account-3')
            ->category('NonTaxable')
            ->calculationType('FixedAmount')
            ->standardAmount('25.00')
            ->standardTypeOfUnits('Kilometres')
            ->standardRatePerUnit(0.95)
            ->idempotencyKey('reimbursement-key')
            ->save();

        self::assertSame('/payroll.xro/2.0/Settings', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/2.0/Settings/TrackingCategories', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/StatutoryDeductions', $transport->requests()[2]->path);
        self::assertSame(2, $transport->requests()[2]->query['page']);
        self::assertSame('/payroll.xro/2.0/StatutoryDeductions/deduction-1', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements', $transport->requests()[4]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements/reimbursement-1', $transport->requests()[5]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements', $transport->requests()[6]->path);
        self::assertSame('reimbursement-key', $transport->requests()[6]->headers['Idempotency-Key']);
        self::assertSame('NonTaxable', $transport->requests()[6]->json['reimbursementCategory'] ?? null);
        self::assertSame(0.95, $transport->requests()[6]->json['standardRatePerUnit'] ?? null);
        self::assertSame('account-1', $settings->getAccounts()[0]['accountID'] ?? null);
        self::assertSame('tracking-1', $trackingCategories['employeeGroupsTrackingCategoryID'] ?? null);
        $firstDed = $deductions->first();
        self::assertNotNull($firstDed);
        self::assertSame('KiwiSaver', $firstDed->getName());
        self::assertSame('deduction-1', $deduction?->getId());
        self::assertSame('Mileage', $reimbursements->first()?->getName());
        self::assertSame('reimbursement-1', $reimbursement?->getReimbursementID());
        self::assertSame('reimbursement-2', $created->getReimbursementID());
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

    public function test_reimbursement_save_returns_blank_model_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $reimbursement = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->settings()
            ->createReimbursement()
            ->name('Meals')
            ->save();

        self::assertNull($reimbursement->getReimbursementID());
    }

    public function test_reimbursement_exposes_all_fields(): void
    {
        $reimbursement = (new Reimbursement())->fill([
            'reimbursementID' => 'reimbursement-1',
            'name' => 'Mileage',
            'accountID' => 'account-2',
            'currentRecord' => true,
            'reimbursementCategory' => 'NonTaxable',
            'calculationType' => 'FixedAmount',
            'standardAmount' => '25.00',
            'standardTypeOfUnits' => 'Kilometres',
            'standardRatePerUnit' => 0.95,
        ]);

        self::assertSame('reimbursement-1', $reimbursement->getReimbursementID());
        self::assertSame('Mileage', $reimbursement->getName());
        self::assertSame('account-2', $reimbursement->getAccountID());
        self::assertTrue($reimbursement->getCurrentRecord());
        self::assertSame('NonTaxable', $reimbursement->getReimbursementCategory());
        self::assertSame('FixedAmount', $reimbursement->getCalculationType());
        self::assertSame('25.00', $reimbursement->getStandardAmount());
        self::assertSame('Kilometres', $reimbursement->getStandardTypeOfUnits());
        self::assertSame(0.95, $reimbursement->getStandardRatePerUnit());
    }
}
