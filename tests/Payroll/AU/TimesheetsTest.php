<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use RuntimeException;
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
        self::assertSame('timesheet-1', $timesheet?->getTimesheetID());
        self::assertSame('timesheet-2', $created->getTimesheetID());
        self::assertSame('APPROVED', $updated->getStatus());
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->timesheets()
            ->scopes();

        self::assertSame(['payroll.timesheets'], $scopes->broad);
        self::assertSame(['payroll.timesheets.read', 'payroll.timesheets'], $scopes->granular);
    }

    public function test_it_can_paginate_timesheets(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['Timesheets' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
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
            'TimesheetID' => 'timesheet-1',
            'EmployeeID' => 'employee-1',
            'StartDate' => '/Date(1572912000000+0000)/',
            'EndDate' => '/Date(1573516800000+0000)/',
            'Status' => 'DRAFT',
        ]);

        self::assertSame('timesheet-1', $timesheet->getTimesheetID());
        self::assertSame('employee-1', $timesheet->getEmployeeID());
        self::assertSame('/Date(1572912000000+0000)/', $timesheet->getStartDate());
        self::assertSame('/Date(1573516800000+0000)/', $timesheet->getEndDate());
        self::assertSame('DRAFT', $timesheet->getStatus());
    }

    public function test_it_can_save_a_found_timesheet(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Timesheets' => [[
                'TimesheetID' => 'timesheet-1',
                'EmployeeID' => 'employee-1',
                'StartDate' => '2026-03-23',
                'EndDate' => '2026-03-29',
                'Status' => 'DRAFT',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Timesheets' => [[
                'TimesheetID' => 'timesheet-1',
                'EmployeeID' => 'employee-1',
                'StartDate' => '2026-03-23',
                'EndDate' => '2026-03-29',
                'Status' => 'APPROVED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $timesheet = $client->payroll()->au()->timesheets()->find('timesheet-1');
        $saved = $timesheet?->setStatus('APPROVED')->save();

        self::assertSame('POST', $transport->requests()[1]->method);
        self::assertSame('/payroll.xro/1.0/Timesheets/timesheet-1', $transport->requests()[1]->path);
        self::assertSame([
            'Timesheets' => [[
                'EmployeeID' => 'employee-1',
                'StartDate' => '2026-03-23',
                'EndDate' => '2026-03-29',
                'Status' => 'APPROVED',
                'TimesheetID' => 'timesheet-1',
            ]],
        ], $transport->requests()[1]->json);
        self::assertSame('APPROVED', $saved?->getStatus());
    }

    public function test_timesheet_save_requires_client(): void
    {
        $this->expectException(RuntimeException::class);

        (new Timesheet())->save();
    }

    public function test_it_sends_idempotency_key_and_returns_blank_timesheet_on_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $timesheet = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->timesheets()
            ->create()
            ->employee('employee-1')
            ->idempotencyKey('key-123')
            ->save();

        self::assertSame('key-123', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertNull($timesheet->getTimesheetID());
    }
}
