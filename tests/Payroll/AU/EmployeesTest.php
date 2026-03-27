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
    public function test_it_can_query_find_create_and_update_payroll_au_employees(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Jane',
                'LastName' => 'Smith',
                'EmailAddress' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Jane',
                'LastName' => 'Smith',
                'EmailAddress' => 'jane@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'EmailAddress' => 'grace@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employee' => [
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Grace',
                'LastName' => 'Hopper',
                'EmailAddress' => 'grace@example.test',
                'Status' => 'ACTIVE',
            ],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employees = $client->payroll()
            ->au()
            ->employees()
            ->where('Status=="ACTIVE"')
            ->orderBy('LastName ASC')
            ->page(2)
            ->get();
        $employee = $client->payroll()->au()->employees()->find('employee-1');
        $created = $client->payroll()->au()->employees()->create()
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();
        $updated = $client->payroll()->au()->employees()->update('employee-2')
            ->firstName('Grace')
            ->lastName('Hopper')
            ->emailAddress('grace@example.test')
            ->save();

        self::assertSame('/payroll.xro/1.0/Employees', $transport->requests()[0]->path);
        self::assertSame('Status=="ACTIVE"', $transport->requests()[0]->query['where']);
        self::assertSame('LastName ASC', $transport->requests()[0]->query['order']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(Employee::class, $employees->first());
        self::assertSame('/payroll.xro/1.0/Employees/employee-1', $transport->requests()[1]->path);
        self::assertSame('/payroll.xro/1.0/Employees', $transport->requests()[2]->path);
        self::assertSame('/payroll.xro/1.0/Employees/employee-2', $transport->requests()[3]->path);
        self::assertSame('Jane', $employees->first()->firstName);
        self::assertSame('employee-1', $employee?->id);
        self::assertSame('employee-2', $created->id);
        self::assertSame('employee-2', $updated->id);
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
