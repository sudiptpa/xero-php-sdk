<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\Employee;
use Sujip\Xero\Xero;

final class EmployeesTest extends TestCase
{
    public function test_it_queries_payroll_au_employees(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Employees' => [[
                    'EmployeeID' => 'employee-1',
                    'FirstName' => 'Jane',
                    'LastName' => 'Smith',
                    'Status' => 'ACTIVE',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $employees = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->employees()
            ->page(2)
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/payroll.xro/1.0/Employees', $request->path);
        self::assertSame(2, $request->query['page']);
        self::assertInstanceOf(Employee::class, $employees->first());
        self::assertSame('Jane', $employees->first()->firstName);
    }

    public function test_it_can_paginate_payroll_au_employees(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Employees' => [],
            ], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->employees()
            ->paginate(page: 3, perPage: 50);

        $request = $transport->requests()[0];

        self::assertSame(3, $request->query['page']);
        self::assertSame(50, $request->query['pageSize']);
        self::assertSame(3, $page->page);
        self::assertSame(50, $page->perPage);
    }
}
