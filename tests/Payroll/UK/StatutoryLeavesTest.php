<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\UK;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\UK\StatutoryLeave\EmployeeStatutorySickLeave;
use Sujip\Xero\Xero;

final class StatutoryLeavesTest extends TestCase
{
    public function test_it_finds_and_creates_statutory_sick_leave(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'statutorySickLeave' => [
                'statutoryLeaveID' => 'leave-1',
                'employeeID' => 'employee-1',
                'leaveTypeID' => 'type-1',
                'startDate' => '2020-03-28',
                'endDate' => '2020-04-01',
                'workPattern' => ['Monday', 'Tuesday'],
                'isPregnancyRelated' => false,
                'sufficientNotice' => true,
                'isEntitled' => false,
                'entitlementWeeksRequested' => 0.6,
                'entitlementWeeksQualified' => 28,
                'entitlementWeeksRemaining' => 0,
                'overlapsWithOtherLeave' => false,
                'entitlementFailureReasons' => ['AweLowerThanLel'],
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'statutorySickLeave' => [
                'statutoryLeaveID' => 'leave-2',
                'employeeID' => 'employee-1',
                'leaveTypeID' => 'type-1',
                'startDate' => '2020-04-21',
                'endDate' => '2020-04-24',
            ],
        ], JSON_THROW_ON_ERROR)));

        $statutoryLeaves = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->statutoryLeaves();

        $found = $statutoryLeaves->findSick('leave-1');
        $created = $statutoryLeaves->createSick(
            (new EmployeeStatutorySickLeave())
                ->setEmployeeID('employee-1')
                ->setLeaveTypeID('type-1')
                ->setStartDate('2020-04-21')
                ->setEndDate('2020-04-24')
                ->setWorkPattern(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'])
                ->setIsPregnancyRelated(false)
                ->setSufficientNotice(true),
            'sick-key'
        );

        self::assertNotNull($found);
        self::assertSame('leave-1', $found->getStatutoryLeaveID());
        self::assertSame('employee-1', $found->getEmployeeID());
        self::assertSame('type-1', $found->getLeaveTypeID());
        self::assertSame('2020-03-28', $found->getStartDate());
        self::assertSame('2020-04-01', $found->getEndDate());
        self::assertSame(['Monday', 'Tuesday'], $found->getWorkPattern());
        self::assertFalse($found->getIsPregnancyRelated());
        self::assertTrue($found->getSufficientNotice());
        self::assertFalse($found->getIsEntitled());
        self::assertSame(0.6, $found->getEntitlementWeeksRequested());
        self::assertSame(28.0, $found->getEntitlementWeeksQualified());
        self::assertSame(0.0, $found->getEntitlementWeeksRemaining());
        self::assertFalse($found->getOverlapsWithOtherLeave());
        self::assertSame(['AweLowerThanLel'], $found->getEntitlementFailureReasons());

        $getRequest = $transport->requests()[0];
        self::assertSame('GET', $getRequest->method);
        self::assertSame('/payroll.xro/2.0/StatutoryLeaves/Sick/leave-1', $getRequest->path);

        $createRequest = $transport->requests()[1];
        self::assertSame('POST', $createRequest->method);
        self::assertSame('/payroll.xro/2.0/StatutoryLeaves/Sick', $createRequest->path);
        self::assertSame('sick-key', $createRequest->headers['Idempotency-Key']);
        self::assertSame([
            'employeeID' => 'employee-1',
            'leaveTypeID' => 'type-1',
            'startDate' => '2020-04-21',
            'endDate' => '2020-04-24',
            'workPattern' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'isPregnancyRelated' => false,
            'sufficientNotice' => true,
        ], $createRequest->json);
        self::assertSame('leave-2', $created->getStatutoryLeaveID());
    }

    public function test_it_returns_null_when_sick_leave_is_missing(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{}'));

        $statutoryLeaves = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->payroll()->uk()->statutoryLeaves();

        self::assertNull($statutoryLeaves->findSick('missing'));
    }

    public function test_it_exposes_scopes(): void
    {
        $statutoryLeaves = Xero::withAccessToken('token', new FakeTransport())->tenant('tenant-123')
            ->payroll()->uk()->statutoryLeaves();

        $scopes = $statutoryLeaves->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }

    public function test_it_hydrates_type_and_status(): void
    {
        $leave = (new EmployeeStatutorySickLeave())->fill([
            'statutoryLeaveID' => 'leave-1',
            'type' => 'Sick',
            'status' => 'Pending',
        ]);

        self::assertSame('leave-1', $leave->getStatutoryLeaveID());
        self::assertSame('Sick', $leave->getType());
        self::assertSame('Pending', $leave->getStatus());
        self::assertSame(['statutoryLeaveID' => 'leave-1'], $leave->toRequest());
    }

    public function test_it_omits_empty_work_pattern_from_request(): void
    {
        $leave = (new EmployeeStatutorySickLeave())
            ->setEmployeeID('employee-1')
            ->setLeaveTypeID('type-1')
            ->setStartDate('2020-04-21')
            ->setEndDate('2020-04-24')
            ->setIsPregnancyRelated(true)
            ->setSufficientNotice(false);

        self::assertSame([
            'employeeID' => 'employee-1',
            'leaveTypeID' => 'type-1',
            'startDate' => '2020-04-21',
            'endDate' => '2020-04-24',
            'isPregnancyRelated' => true,
            'sufficientNotice' => false,
        ], $leave->toRequest());
        self::assertSame([], $leave->getWorkPattern());
    }
}
