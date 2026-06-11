<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\Settings\Reimbursement;
use Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary;
use Sujip\Xero\Payroll\UK\Settings\TrackingCategory;
use Sujip\Xero\Xero;

final class SettingsTest extends TestCase
{
    public function test_it_can_load_payroll_uk_settings_helpers(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'TrackingCategories' => [[
                'employeeGroupsTrackingCategoryID' => 'employee-groups-1',
                'timesheetTrackingCategoryID' => 'timesheet-1',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Reimbursements' => [[
                'ReimbursementID' => 'reimbursement-1',
                'Name' => 'Travel',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Reimbursement' => [
                'ReimbursementID' => 'reimbursement-1',
                'Name' => 'Travel',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'StatutoryLeaveSummary' => [
                'EmployeeID' => 'employee-1',
                'Units' => 'DAYS',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Reimbursement' => [
                'ReimbursementID' => 'reimbursement-2',
                'Name' => 'Meals',
                'AccountCode' => '400',
            ],
        ], JSON_THROW_ON_ERROR)));

        $settings = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->settings();

        $trackingCategories = $settings->trackingCategories();
        $reimbursements = $settings->reimbursements();
        $reimbursement = $settings->reimbursement('reimbursement-1');
        $summary = $settings->statutoryLeaveSummary('employee-1');
        $created = $settings->createReimbursement()
            ->name('Meals')
            ->accountCode('400')
            ->idempotencyKey('reimbursement-key')
            ->save();

        self::assertSame('/payroll.xro/2.0/Settings/trackingCategories', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements/reimbursement-1', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/2.0/StatutoryLeaves/Summary/employee-1', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements', $transport->requests()[4]->path);
        self::assertSame('reimbursement-key', $transport->requests()[4]->headers['Idempotency-Key']);
        $firstTc = $trackingCategories->first();
        self::assertNotNull($firstTc);
        self::assertSame('employee-groups-1', $firstTc->getEmployeeGroupsTrackingCategoryID());
        self::assertSame('timesheet-1', $firstTc->getTimesheetTrackingCategoryID());
        $firstReimb = $reimbursements->first();
        self::assertNotNull($firstReimb);
        self::assertSame('Travel', $firstReimb->getName());
        self::assertSame('reimbursement-1', $reimbursement?->getReimbursementID());
        self::assertSame('employee-1', $summary->getEmployeeID());
        self::assertSame('reimbursement-2', $created->getReimbursementID());
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->settings()
            ->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }

    public function test_it_returns_blank_statutory_leave_summary_when_response_has_no_summary(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $summary = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->settings()
            ->statutoryLeaveSummary('employee-1');

        self::assertNull($summary->getEmployeeID());
        self::assertNull($summary->getUnits());
    }

    public function test_reimbursement_save_returns_blank_model_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $reimbursement = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->settings()
            ->createReimbursement()
            ->name('Travel')
            ->save();

        self::assertNull($reimbursement->getReimbursementID());
    }

    public function test_reimbursement_exposes_all_fields(): void
    {
        $reimbursement = (new Reimbursement())->fill([
            'ReimbursementID' => 'reimbursement-1',
            'Name' => 'Travel',
            'AccountCode' => '400',
        ]);

        self::assertSame('reimbursement-1', $reimbursement->getReimbursementID());
        self::assertSame('Travel', $reimbursement->getName());
        self::assertSame('400', $reimbursement->getAccountCode());
    }

    public function test_statutory_leave_summary_exposes_all_fields(): void
    {
        $summary = (new StatutoryLeaveSummary())->fill([
            'EmployeeID' => 'employee-1',
            'Units' => 'Hours',
        ]);

        self::assertSame('employee-1', $summary->getEmployeeID());
        self::assertSame('Hours', $summary->getUnits());
    }

    public function test_tracking_category_exposes_all_fields(): void
    {
        $trackingCategory = (new TrackingCategory())->fill([
            'TrackingCategoryID' => 'tracking-1',
            'Name' => 'Region',
            'EmployeeGroupsTrackingCategoryID' => 'employee-groups-1',
            'TimesheetTrackingCategoryID' => 'timesheet-1',
        ]);

        self::assertSame('tracking-1', $trackingCategory->getTrackingCategoryID());
        self::assertSame('Region', $trackingCategory->getName());
        self::assertSame('employee-groups-1', $trackingCategory->getEmployeeGroupsTrackingCategoryID());
        self::assertSame('timesheet-1', $trackingCategory->getTimesheetTrackingCategoryID());
    }
}
