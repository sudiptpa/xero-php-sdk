<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\Timesheet\Timesheet;
use Sujip\Xero\Xero;

final class TimesheetsTest extends TestCase
{
    public function test_it_can_query_find_create_and_update_timesheets(): void
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
                'Status' => 'APPROVED',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $timesheets = $client->payroll()->au()->timesheets()
            ->modifiedSince(new DateTimeImmutable('2026-03-26T00:00:00+00:00'))
            ->where('Status=="DRAFT"')
            ->orderBy('StartDate DESC')
            ->page(2)
            ->get();

        $timesheet = $client->payroll()->au()->timesheets()->find('timesheet-1');
        $created = $client->payroll()->au()->timesheets()->create()
            ->employee('employee-1')
            ->startDate('2026-03-23')
            ->endDate('2026-03-29')
            ->status('DRAFT')
            ->save();
        $updated = $client->payroll()->au()->timesheets()->update('timesheet-2')
            ->employee('employee-1')
            ->startDate('2026-03-23')
            ->endDate('2026-03-29')
            ->status('APPROVED')
            ->save();

        self::assertSame('/payroll.xro/1.0/Timesheets', $transport->requests()[0]->path);
        self::assertSame('Status=="DRAFT"', $transport->requests()[0]->query['where']);
        self::assertSame('StartDate DESC', $transport->requests()[0]->query['order']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(Timesheet::class, $timesheets->first());
        self::assertSame('/payroll.xro/1.0/Timesheets/timesheet-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/Timesheets', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/1.0/Timesheets/timesheet-2', $transport->requests()[3]->path);
        self::assertSame('timesheet-1', $timesheet?->id);
        self::assertSame('timesheet-2', $created->id);
        self::assertSame('APPROVED', $updated->status);
    }
}
