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
}
