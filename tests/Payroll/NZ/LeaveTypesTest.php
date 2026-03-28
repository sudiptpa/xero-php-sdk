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
            'LeaveTypes' => [[
                'LeaveTypeID' => 'leave-type-1',
                'Name' => 'Annual Leave',
                'IsActive' => true,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'LeaveType' => [
                'LeaveTypeID' => 'leave-type-1',
                'Name' => 'Annual Leave',
                'IsActive' => true,
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
}
