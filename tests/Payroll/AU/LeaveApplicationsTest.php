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
}
