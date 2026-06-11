<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\Settings\Reimbursement;
use Sujip\Xero\Payroll\UK\Settings\StatutoryLeaveSummary;
use Sujip\Xero\Xero;

final class SettingsTest extends TestCase
{
    public function test_it_can_load_payroll_uk_settings_helpers(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'trackingCategories' => [
                'employeeGroupsTrackingCategoryID' => 'employee-groups-1',
                'timesheetTrackingCategoryID' => 'timesheet-1',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'reimbursements' => [[
                'reimbursementID' => 'reimbursement-1',
                'name' => 'Travel',
                'accountID' => 'account-1',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'reimbursement' => [
                'reimbursementID' => 'reimbursement-1',
                'name' => 'Travel',
                'accountID' => 'account-1',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'statutoryLeaves' => [[
                'statutoryLeaveID' => 'leave-1',
                'employeeID' => 'employee-1',
                'type' => 'Sick',
                'isEntitled' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'reimbursement' => [
                'reimbursementID' => 'reimbursement-2',
                'name' => 'Meals',
                'accountID' => 'account-2',
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
        $summaries = $settings->statutoryLeaveSummary('employee-1');
        $created = $settings->createReimbursement()
            ->name('Meals')
            ->account('account-2')
            ->idempotencyKey('reimbursement-key')
            ->save();

        self::assertSame('/payroll.xro/2.0/Settings/trackingCategories', $transport->requests()[0]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements/reimbursement-1', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/2.0/StatutoryLeaves/Summary/employee-1', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/2.0/Reimbursements', $transport->requests()[4]->path);
        self::assertSame('reimbursement-key', $transport->requests()[4]->headers['Idempotency-Key']);
        self::assertSame([
            'name' => 'Meals',
            'accountID' => 'account-2',
        ], $transport->requests()[4]->json);
        self::assertSame('employee-groups-1', $trackingCategories['employeeGroupsTrackingCategoryID'] ?? null);
        self::assertSame('timesheet-1', $trackingCategories['timesheetTrackingCategoryID'] ?? null);
        $firstReimb = $reimbursements->first();
        self::assertNotNull($firstReimb);
        self::assertSame('Travel', $firstReimb->getName());
        self::assertSame('reimbursement-1', $reimbursement?->getReimbursementID());
        self::assertSame('employee-1', $summaries->first()?->getEmployeeID());
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

    public function test_it_returns_empty_collection_when_response_has_no_statutory_leaves(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $summaries = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->settings()
            ->statutoryLeaveSummary('employee-1');

        self::assertNull($summaries->first());
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
            'reimbursementID' => 'reimbursement-1',
            'name' => 'Travel',
            'accountID' => 'account-1',
            'currentRecord' => true,
        ]);

        self::assertSame('reimbursement-1', $reimbursement->getReimbursementID());
        self::assertSame('Travel', $reimbursement->getName());
        self::assertSame('account-1', $reimbursement->getAccountID());
        self::assertTrue($reimbursement->getCurrentRecord());
    }

    public function test_statutory_leave_summary_exposes_all_fields(): void
    {
        $summary = (new StatutoryLeaveSummary())->fill([
            'statutoryLeaveID' => 'leave-1',
            'employeeID' => 'employee-1',
            'type' => 'Sick',
            'startDate' => '2026-04-01',
            'endDate' => '2026-04-05',
            'isEntitled' => true,
            'status' => 'Pending',
        ]);

        self::assertSame('leave-1', $summary->getStatutoryLeaveID());
        self::assertSame('employee-1', $summary->getEmployeeID());
        self::assertSame('Sick', $summary->getType());
        self::assertSame('2026-04-01', $summary->getStartDate());
        self::assertSame('2026-04-05', $summary->getEndDate());
        self::assertTrue($summary->getIsEntitled());
        self::assertSame('Pending', $summary->getStatus());
    }
}
