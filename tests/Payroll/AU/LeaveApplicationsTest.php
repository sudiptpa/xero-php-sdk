<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\LeaveApplication\LeaveApplication;
use Sujip\Xero\Xero;

final class LeaveApplicationsTest extends TestCase
{
    public function test_it_can_query_find_create_update_approve_and_reject_leave_applications(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplications' => [[
                'LeaveApplicationID' => 'leave-1',
                'EmployeeID' => 'employee-1',
                'LeaveTypeID' => 'type-1',
                'Title' => 'Annual Leave',
                'Status' => 'REQUESTED',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => [
                'LeaveApplicationID' => 'leave-1',
                'Status' => 'REQUESTED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => [
                'LeaveApplicationID' => 'leave-2',
                'EmployeeID' => 'employee-1',
                'LeaveTypeID' => 'type-1',
                'Title' => 'Annual Leave',
                'Status' => 'REQUESTED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => [
                'LeaveApplicationID' => 'leave-2',
                'Status' => 'APPROVED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => [
                'LeaveApplicationID' => 'leave-2',
                'Status' => 'APPROVED',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => [
                'LeaveApplicationID' => 'leave-2',
                'Status' => 'REJECTED',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $applications = $client->payroll()->au()->leaveApplications()
            ->modifiedSince(new DateTimeImmutable('2026-03-26T00:00:00+00:00'))
            ->where('Status=="REQUESTED"')
            ->orderBy('StartDate DESC')
            ->page(2)
            ->get();

        $application = $client->payroll()->au()->leaveApplications()->find('leave-1');
        $created = $client->payroll()->au()->leaveApplications()->create()
            ->employee('employee-1')
            ->leaveType('type-1')
            ->title('Annual Leave')
            ->startDate('2026-04-01')
            ->endDate('2026-04-02')
            ->save();
        $updated = $client->payroll()->au()->leaveApplications()->update('leave-2')
            ->employee('employee-1')
            ->leaveType('type-1')
            ->title('Annual Leave')
            ->startDate('2026-04-01')
            ->endDate('2026-04-02')
            ->save();
        $approved = $updated->approve();
        $rejected = $approved->reject();

        self::assertSame('/payroll.xro/1.0/LeaveApplications', $transport->requests()[0]->path);
        self::assertSame('Status=="REQUESTED"', $transport->requests()[0]->query['where']);
        self::assertSame('StartDate DESC', $transport->requests()[0]->query['order']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(LeaveApplication::class, $applications->first());
        self::assertSame('/payroll.xro/1.0/LeaveApplications/leave-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/LeaveApplications', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/1.0/LeaveApplications/leave-2', $transport->requests()[3]->path);
        self::assertSame('/payroll.xro/1.0/LeaveApplications/leave-2/approve', $transport->requests()[4]->path);
        self::assertSame('/payroll.xro/1.0/LeaveApplications/leave-2/reject', $transport->requests()[5]->path);
        self::assertSame('leave-2', $updated->getLeaveApplicationID());
        self::assertSame('REJECTED', $rejected->getStatus());
        self::assertSame('leave-1', $application?->getLeaveApplicationID());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->leaveApplications();

        $scopes = $resource->scopes();

        self::assertSame(['payroll.employees'], $scopes->broad);
        self::assertSame(['payroll.employees.read', 'payroll.employees'], $scopes->granular);
    }

    public function test_it_queries_v2_leave_applications_including_requests(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'LeaveApplications' => [[
                    'LeaveApplicationID' => 'leave-1',
                    'EmployeeID' => 'employee-1',
                    'Status' => 'SCHEDULED',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $applications = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->leaveApplications()
            ->where('Status=="SCHEDULED"')
            ->v2();

        $request = $transport->requests()[0];
        self::assertSame('/payroll.xro/1.0/LeaveApplications/v2', $request->path);
        self::assertSame('Status=="SCHEDULED"', $request->query['where']);
        self::assertSame('leave-1', $applications->first()?->getLeaveApplicationID());
    }

    public function test_it_can_paginate_leave_applications(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['LeaveApplications' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->leaveApplications()
            ->paginate(page: 2, perPage: 20);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(20, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(20, $page->perPage);
    }

    public function test_model_getters_and_status_helper(): void
    {
        $application = (new LeaveApplication())->fill([
            'LeaveApplicationID' => 'leave-1',
            'LeaveTypeID' => 'type-1',
            'Title' => 'Annual Leave',
            'StartDate' => '2026-04-01',
            'EndDate' => '2026-04-02',
        ]);

        self::assertSame('type-1', $application->getLeaveTypeID());
        self::assertSame('Annual Leave', $application->getTitle());
        self::assertSame('2026-04-01', $application->getStartDate());
        self::assertSame('2026-04-02', $application->getEndDate());
        self::assertSame('APPROVED', $application->status('approved')->getStatus());
    }

    public function test_loaded_model_can_be_saved(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => ['LeaveApplicationID' => 'leave-1'],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveApplication' => ['LeaveApplicationID' => 'leave-1', 'Title' => 'Sick Leave'],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $application = $client->payroll()->au()->leaveApplications()->find('leave-1');
        self::assertNotNull($application);

        $saved = $application
            ->setEmployeeID('employee-1')
            ->setLeaveTypeID('type-1')
            ->setTitle('Sick Leave')
            ->setStartDate('2026-04-01')
            ->setEndDate('2026-04-02')
            ->save();

        self::assertSame('/payroll.xro/1.0/LeaveApplications/leave-1', $transport->requests()[1]->path);
        self::assertSame('leave-1', $saved->getLeaveApplicationID());
    }

    public function test_payload_sends_idempotency_key_and_handles_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $result = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->leaveApplications()
            ->create()
            ->title('Annual Leave')
            ->idempotencyKey('key-123')
            ->save();

        self::assertSame('key-123', $transport->requests()[0]->headers['Idempotency-Key'] ?? null);
        self::assertNull($result->getLeaveApplicationID());
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new LeaveApplication())->save();
    }

    public function test_approve_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new LeaveApplication())->approve();
    }

    public function test_reject_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new LeaveApplication())->reject();
    }
}
