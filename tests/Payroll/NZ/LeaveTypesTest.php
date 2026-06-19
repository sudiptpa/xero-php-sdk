<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\NZ;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\NZ\LeaveType\LeaveType;
use Sujip\Xero\Xero;

final class LeaveTypesTest extends TestCase
{
    public function test_it_can_query_and_find_leave_types(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'leaveTypes' => [[
                'leaveTypeID' => 'leave-type-1',
                'name' => 'Annual Leave',
                'isActive' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'leaveType' => [
                'leaveTypeID' => 'leave-type-1',
                'name' => 'Annual Leave',
                'isActive' => true,
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $types = $client->payroll()->nz()->leaveTypes()->activeOnly()->page(2)->get();
        $type = $client->payroll()->nz()->leaveTypes()->find('leave-type-1');

        self::assertSame('/payroll.xro/2.0/LeaveTypes', $transport->requests()[0]->path);
        self::assertTrue($transport->requests()[0]->query['ActiveOnly']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(LeaveType::class, $types->first());
        self::assertSame('/payroll.xro/2.0/LeaveTypes/leave-type-1', $transport->requests()[1]->path);
        self::assertSame('leave-type-1', $type?->getLeaveTypeID());
    }

    public function test_it_exposes_scopes(): void
    {
        $scopes = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->leaveTypes()
            ->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }

    public function test_it_can_paginate_leave_types(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['leaveTypes' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->nz()
            ->leaveTypes()
            ->paginate(page: 2, perPage: 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
    }

    public function test_leave_type_exposes_all_fields(): void
    {
        $type = (new LeaveType())->fill([
            'leaveTypeID' => 'leave-type-1',
            'name' => 'Annual Leave',
            'isPaidLeave' => true,
            'showOnPayslip' => true,
            'updatedDateUTC' => '2026-03-29T00:00:00',
            'isActive' => true,
            'typeOfUnits' => 'Hours',
            'typeOfUnitsToAccrue' => 'Days',
        ]);

        self::assertSame('leave-type-1', $type->getLeaveTypeID());
        self::assertSame('Annual Leave', $type->getName());
        self::assertTrue($type->getIsPaidLeave());
        self::assertTrue($type->getShowOnPayslip());
        self::assertSame('2026-03-29T00:00:00', $type->getUpdatedDateUTC());
        self::assertTrue($type->getIsActive());
        self::assertSame('Hours', $type->getTypeOfUnits());
        self::assertSame('Days', $type->getTypeOfUnitsToAccrue());
    }
}
