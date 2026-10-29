<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\Timesheet\Timesheet;
use Sujip\Xero\Payroll\AU\Timesheet\TimesheetLine;
use Sujip\Xero\Xero;

final class TimesheetsTest extends TestCase
{
    public function test_it_uses_au_payroll_v2_for_list_find_create_and_transitions(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode(['timesheets' => [[
            'timesheetID' => 'timesheet-1',
            'payrollCalendarID' => 'calendar-1',
            'employeeID' => 'employee-1',
            'status' => 'Draft',
        ]]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode(['timesheet' => [
            'timesheetID' => 'timesheet-1', 'employeeID' => 'employee-1', 'status' => 'Draft',
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode(['timesheet' => [
            'timesheetID' => 'timesheet-2', 'employeeID' => 'employee-1', 'status' => 'Draft',
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode(['timesheet' => [
            'timesheetID' => 'timesheet-2', 'status' => 'Approved',
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode(['timesheet' => [
            'timesheetID' => 'timesheet-2', 'status' => 'Draft',
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');
        $timesheets = $client->payroll()->au()->timesheets();
        $listed = $timesheets
            ->filter('employeeId==employee-1')
            ->status('Draft')
            ->startDate('2026-03-01')
            ->endDate('2026-03-31')
            ->sort('startDate')
            ->page(2)
            ->get();
        $found = $timesheets->find('timesheet-1');
        $created = $timesheets->create()
            ->payrollCalendar('calendar-1')
            ->employee('employee-1')
            ->startDate('2026-03-23')
            ->endDate('2026-03-29')
            ->timesheetLines([(new TimesheetLine())->setDate('2026-03-23')->setEarningsRateID('rate-1')->setNumberOfUnits(8.0)])
            ->idempotencyKey('create-key')
            ->save();
        $approved = $created->approve();
        $reverted = $approved->revert();
        $deleted = $reverted->delete();

        $listRequest = $transport->requests()[0];
        self::assertSame('/payroll.xro/2.0/Timesheets', $listRequest->path);
        self::assertSame('employeeId==employee-1', $listRequest->query['filter']);
        self::assertSame('Draft', $listRequest->query['status']);
        self::assertSame('2026-03-01', $listRequest->query['startDate']);
        self::assertSame('2026-03-31', $listRequest->query['endDate']);
        self::assertSame('startDate', $listRequest->query['sort']);
        self::assertSame(2, $listRequest->query['page']);
        self::assertInstanceOf(Timesheet::class, $listed->first());
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1', $transport->requests()[1]->path);
        self::assertSame('POST', $transport->requests()[2]->method);
        self::assertSame('create-key', $transport->requests()[2]->headers['Idempotency-Key']);
        self::assertSame([
            'payrollCalendarID' => 'calendar-1',
            'employeeID' => 'employee-1',
            'startDate' => '2026-03-23',
            'endDate' => '2026-03-29',
            'timesheetLines' => [[
                'date' => '2026-03-23',
                'earningsRateID' => 'rate-1',
                'numberOfUnits' => 8.0,
            ]],
        ], $transport->requests()[2]->json);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2/Approve', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2/RevertToDraft', $transport->requests()[4]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2', $transport->requests()[5]->path);
        self::assertSame('timesheet-1', $found?->getTimesheetID());
        self::assertSame('Approved', $approved->getStatus());
        self::assertSame('Draft', $reverted->getStatus());
        self::assertTrue($deleted);
    }

    public function test_it_maps_v2_fields_and_typed_lines(): void
    {
        $timesheet = (new Timesheet())->fill([
            'timesheetID' => 'timesheet-1',
            'payrollCalendarID' => 'calendar-1',
            'employeeID' => 'employee-1',
            'startDate' => '2026-03-23',
            'endDate' => '2026-03-29',
            'status' => 'Draft',
            'totalHours' => 17,
            'updatedDateUTC' => '2026-03-29T00:00:00',
            'timesheetLines' => [[
                'timesheetLineID' => 'line-1',
                'date' => '2026-03-23T00:00:00',
                'earningsRateID' => 'rate-1',
                'trackingItemID' => 'tracking-1',
                'numberOfUnits' => 8,
            ]],
        ]);

        self::assertSame('calendar-1', $timesheet->getPayrollCalendarID());
        self::assertSame('employee-1', $timesheet->getEmployeeID());
        self::assertSame('2026-03-23', $timesheet->getStartDate());
        self::assertSame('2026-03-29', $timesheet->getEndDate());
        self::assertSame('2026-03-29T00:00:00', $timesheet->getUpdatedDateUTC());
        self::assertSame(17.0, $timesheet->getTotalHours());
        self::assertSame(8.0, $timesheet->getTimesheetLines()[0]->getNumberOfUnits());
        self::assertSame('line-1', $timesheet->getTimesheetLines()[0]->getTimesheetLineID());
        self::assertSame('2026-03-23T00:00:00', $timesheet->getTimesheetLines()[0]->getDate());
        self::assertSame('rate-1', $timesheet->getTimesheetLines()[0]->getEarningsRateID());
        self::assertSame('tracking-1', $timesheet->getTimesheetLines()[0]->getTrackingItemID());
    }

    public function test_it_creates_updates_and_deletes_lines(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode(['timesheetLine' => [
            'timesheetLineID' => 'line-1', 'date' => '2026-03-23', 'earningsRateID' => 'rate-1', 'numberOfUnits' => 8,
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode(['timesheetLine' => [
            'timesheetLineID' => 'line-1', 'numberOfUnits' => 6,
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $timesheets = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->payroll()->au()->timesheets();
        $line = (new TimesheetLine())->setDate('2026-03-23')->setEarningsRateID('rate-1')->setNumberOfUnits(8.0);
        $created = $timesheets->createLine('timesheet-1', $line, 'line-key');
        $updated = $timesheets->updateLine('timesheet-1', 'line-1', $line->setNumberOfUnits(6.0));
        $deleted = $timesheets->deleteLine('timesheet-1', 'line-1');

        self::assertSame('POST', $transport->requests()[0]->method);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1/Lines', $transport->requests()[0]->path);
        self::assertSame('line-key', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame(['date' => '2026-03-23', 'earningsRateID' => 'rate-1', 'numberOfUnits' => 8.0], $transport->requests()[0]->json);
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1/Lines/line-1', $transport->requests()[1]->path);
        self::assertSame(6.0, $updated->getNumberOfUnits());
        self::assertSame('line-1', $created->getTimesheetLineID());
        self::assertTrue($deleted);
    }

    public function test_it_can_paginate_timesheets(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode(['timesheets' => []], JSON_THROW_ON_ERROR)));
        $page = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->payroll()->au()->timesheets()->paginate(2, 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame('/payroll.xro/2.0/Timesheets', $page->meta['path']);
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-123')->payroll()->au()->timesheets()->scopes();

        self::assertSame(['payroll.timesheets'], $scopes->broad);
        self::assertSame(['payroll.timesheets.read', 'payroll.timesheets'], $scopes->granular);
    }

    public function test_timesheet_actions_require_client_and_id(): void
    {
        $this->expectException(RuntimeException::class);
        (new Timesheet())->approve();
    }

    public function test_timesheet_actions_require_a_timesheet_id(): void
    {
        $client = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-123');

        $this->expectException(RuntimeException::class);
        (new Timesheet($client))->approve();
    }
}
