<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\Timesheet\Timesheet;
use Sujip\Xero\Payroll\UK\Timesheet\TimesheetLine;
use Sujip\Xero\Xero;

final class TimesheetsTest extends TestCase
{
    public function test_it_can_query_find_create_approve_revert_and_delete_timesheets(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'timesheets' => [[
                'timesheetID' => 'timesheet-1',
                'employeeID' => 'employee-1',
                'status' => 'Draft',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'timesheet' => [
                'timesheetID' => 'timesheet-1',
                'employeeID' => 'employee-1',
                'status' => 'Draft',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'timesheet' => [
                'timesheetID' => 'timesheet-2',
                'employeeID' => 'employee-1',
                'status' => 'Draft',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'timesheet' => [
                'timesheetID' => 'timesheet-2',
                'employeeID' => 'employee-1',
                'status' => 'Approved',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'timesheet' => [
                'timesheetID' => 'timesheet-2',
                'employeeID' => 'employee-1',
                'status' => 'Draft',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $timesheets = $client->payroll()->uk()->timesheets()->status('Draft')->page(2)->get();
        $timesheet = $client->payroll()->uk()->timesheets()->find('timesheet-1');
        $created = $client->payroll()->uk()->timesheets()->create()
            ->payrollCalendar('calendar-1')
            ->employee('employee-1')
            ->startDate('2026-03-23')
            ->endDate('2026-03-29')
            ->status('Draft')
            ->save();
        $approved = $created->approve();
        $reverted = $approved->revert();
        $deleted = $reverted->delete();

        self::assertSame('/payroll.xro/2.0/Timesheets', $transport->requests()[0]->path);
        self::assertSame('Draft', $transport->requests()[0]->query['status']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(Timesheet::class, $timesheets->first());
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1', $transport->requests()[1]->path);
        self::assertSame('POST', $transport->requests()[2]->method);
        self::assertSame('/payroll.xro/2.0/Timesheets', $transport->requests()[2]->path);
        self::assertSame([
            'payrollCalendarID' => 'calendar-1',
            'employeeID' => 'employee-1',
            'startDate' => '2026-03-23',
            'endDate' => '2026-03-29',
            'status' => 'Draft',
        ], $transport->requests()[2]->json);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2/Approve', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2/RevertToDraft', $transport->requests()[4]->path);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-2', $transport->requests()[5]->path);
        self::assertSame('timesheet-1', $timesheet?->getTimesheetID());
        self::assertSame('timesheet-2', $created->getTimesheetID());
        self::assertSame('Approved', $approved->getStatus());
        self::assertSame('Draft', $reverted->getStatus());
        self::assertTrue($deleted);
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->timesheets()
            ->scopes();

        self::assertSame(['payroll.timesheets'], $scopes->broad);
        self::assertSame(['payroll.timesheets.read', 'payroll.timesheets'], $scopes->granular);
    }

    public function test_it_can_paginate_timesheets(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['timesheets' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->timesheets()
            ->paginate(page: 2, perPage: 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
    }

    public function test_timesheet_exposes_all_fields(): void
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
            'timesheetLines' => [
                [
                    'timesheetLineID' => 'line-1',
                    'date' => '2026-03-23',
                    'earningsRateID' => 'rate-1',
                    'trackingItemID' => 'tracking-1',
                    'numberOfUnits' => 8,
                ],
            ],
        ]);

        self::assertSame('timesheet-1', $timesheet->getTimesheetID());
        self::assertSame('calendar-1', $timesheet->getPayrollCalendarID());
        self::assertSame('employee-1', $timesheet->getEmployeeID());
        self::assertSame('2026-03-23', $timesheet->getStartDate());
        self::assertSame('2026-03-29', $timesheet->getEndDate());
        self::assertSame('Draft', $timesheet->getStatus());
        self::assertSame(17.0, $timesheet->getTotalHours());
        self::assertSame('2026-03-29T00:00:00', $timesheet->getUpdatedDateUTC());

        $lines = $timesheet->getTimesheetLines();
        self::assertCount(1, $lines);
        self::assertSame('line-1', $lines[0]->getTimesheetLineID());
        self::assertSame('2026-03-23', $lines[0]->getDate());
        self::assertSame('rate-1', $lines[0]->getEarningsRateID());
        self::assertSame('tracking-1', $lines[0]->getTrackingItemID());
        self::assertSame(8.0, $lines[0]->getNumberOfUnits());
    }

    public function test_it_can_save_a_found_timesheet(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'timesheet' => [
                'timesheetID' => 'timesheet-1',
                'payrollCalendarID' => 'calendar-1',
                'employeeID' => 'employee-1',
                'startDate' => '2026-03-23',
                'endDate' => '2026-03-29',
                'status' => 'Draft',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'timesheet' => [
                'timesheetID' => 'timesheet-1',
                'payrollCalendarID' => 'calendar-1',
                'employeeID' => 'employee-1',
                'startDate' => '2026-03-23',
                'endDate' => '2026-03-29',
                'status' => 'Approved',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $timesheet = $client->payroll()->uk()->timesheets()->find('timesheet-1');
        $saved = $timesheet?->setStatus('Approved')->save();

        self::assertSame('POST', $transport->requests()[1]->method);
        self::assertSame('/payroll.xro/2.0/Timesheets', $transport->requests()[1]->path);
        self::assertSame([
            'payrollCalendarID' => 'calendar-1',
            'employeeID' => 'employee-1',
            'startDate' => '2026-03-23',
            'endDate' => '2026-03-29',
            'status' => 'Approved',
        ], $transport->requests()[1]->json);
        self::assertSame('Approved', $saved?->getStatus());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Timesheet())->save();
    }

    public function test_approving_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Timesheet())->approve();
    }

    public function test_reverting_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Timesheet())->revert();
    }

    public function test_deleting_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);

        (new Timesheet())->delete();
    }

    public function test_it_sends_idempotency_key_and_returns_blank_timesheet_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $timesheet = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->uk()
            ->timesheets()
            ->create()
            ->employee('employee-1')
            ->idempotencyKey('key-123')
            ->save();

        self::assertSame('key-123', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertNull($timesheet->getTimesheetID());
    }

    public function test_it_creates_updates_and_deletes_timesheet_lines(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'timesheetLine' => [
                'timesheetLineID' => 'line-1',
                'date' => '2020-08-03T00:00:00',
                'earningsRateID' => 'rate-1',
                'trackingItemID' => 'tracking-1',
                'numberOfUnits' => 8,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'timesheetLine' => ['timesheetLineID' => 'line-1', 'numberOfUnits' => 6],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '{}'));

        $timesheets = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->timesheets();

        $created = $timesheets->createLine(
            'timesheet-1',
            (new TimesheetLine())
                ->setDate('2020-08-03')
                ->setEarningsRateID('rate-1')
                ->setNumberOfUnits(8.0),
            'line-key'
        );
        $updated = $timesheets->updateLine(
            'timesheet-1',
            'line-1',
            (new TimesheetLine())->setDate('2020-08-03')->setEarningsRateID('rate-1')->setNumberOfUnits(6.0)
        );
        $deleted = $timesheets->deleteLine('timesheet-1', 'line-1');

        $createRequest = $transport->requests()[0];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1/Lines', $createRequest->path);
        self::assertSame('line-key', $createRequest->headers['Idempotency-Key']);
        self::assertSame([
            'date' => '2020-08-03',
            'earningsRateID' => 'rate-1',
            'numberOfUnits' => 8.0,
        ], $createRequest->json);
        self::assertSame('line-1', $created->getTimesheetLineID());
        self::assertSame('2020-08-03T00:00:00', $created->getDate());
        self::assertSame('rate-1', $created->getEarningsRateID());
        self::assertSame('tracking-1', $created->getTrackingItemID());
        self::assertSame(8.0, $created->getNumberOfUnits());

        $updateRequest = $transport->requests()[1];
        self::assertSame('PUT', $updateRequest->method);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1/Lines/line-1', $updateRequest->path);
        self::assertArrayNotHasKey('Idempotency-Key', $updateRequest->headers);
        self::assertSame(6.0, $updated->getNumberOfUnits());

        self::assertSame('DELETE', $transport->requests()[2]->method);
        self::assertSame('/payroll.xro/2.0/Timesheets/timesheet-1/Lines/line-1', $transport->requests()[2]->path);
        self::assertTrue($deleted);
    }
}
