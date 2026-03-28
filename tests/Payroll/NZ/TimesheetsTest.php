<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\Timesheet\Timesheet;
use Sujip\Xero\Xero;

final class TimesheetsTest extends TestCase
{
    public function test_it_can_query_find_create_update_approve_revert_and_delete_timesheets(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Timesheets' => [[
                'TimesheetID' => 'timesheet-1',
                'EmployeeID' => 'employee-1',
                'Status' => 'DRAFT',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Timesheet' => [
                'TimesheetID' => 'timesheet-1',
                'EmployeeID' => 'employee-1',
                'Status' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Timesheet' => [
                'TimesheetID' => 'timesheet-2',
                'EmployeeID' => 'employee-1',
                'Status' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Timesheet' => [
                'TimesheetID' => 'timesheet-2',
                'EmployeeID' => 'employee-1',
                'Status' => 'SUBMITTED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Timesheet' => [
                'TimesheetID' => 'timesheet-2',
                'EmployeeID' => 'employee-1',
                'Status' => 'APPROVED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Timesheet' => [
                'TimesheetID' => 'timesheet-2',
                'EmployeeID' => 'employee-1',
                'Status' => 'DRAFT',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $timesheets = $client->payroll()->nz()->timesheets()->status('draft')->page(2)->get();
        $timesheet = $client->payroll()->nz()->timesheets()->find('timesheet-1');
        $created = $client->payroll()->nz()->timesheets()->create()
            ->employee('employee-1')
            ->startDate('2026-03-23')
            ->endDate('2026-03-29')
            ->status('DRAFT')
            ->save();
        $updated = $client->payroll()->nz()->timesheets()->update('timesheet-2')
            ->employee('employee-1')
            ->startDate('2026-03-23')
            ->endDate('2026-03-29')
            ->status('SUBMITTED')
            ->save();
        $approved = $updated->approve();
        $reverted = $approved->revert();
        $deleted = $reverted->delete();

        self::assertSame('/payroll.xro/2.0/Timesheets', $transport->requests()[0]->path);
        self::assertSame('DRAFT', $transport->requests()[0]->query['status']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(Timesheet::class, $timesheets->first());
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2/Approve', $transport->requests()[4]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2/Revert', $transport->requests()[5]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2', $transport->requests()[6]->path);
        self::assertSame('timesheet-1', $timesheet?->getTimesheetID());
        self::assertSame('timesheet-2', $created->getTimesheetID());
        self::assertSame('APPROVED', $approved->getStatus());
        self::assertSame('DRAFT', $reverted->getStatus());
        self::assertTrue($deleted);
    }
}
