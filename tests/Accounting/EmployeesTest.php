<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Accounting\Employee\Employee;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class EmployeesTest extends TestCase
{
    public function test_it_can_query_find_create_and_update_employees(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Nick',
                'LastName' => 'Fury',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-1',
                'FirstName' => 'Nick',
                'LastName' => 'Fury',
                'Status' => 'ACTIVE',
                'ExternalLink' => [
                    'LinkType' => 'Website',
                    'Url' => 'https://example.test/nick-fury',
                    'Description' => 'Profile',
                ],
                'UpdatedDateUTC' => '2026-03-25T00:00:00',
                'StatusAttributeString' => 'ERROR',
                'ValidationErrors' => [['Message' => 'Invalid status']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Maria',
                'LastName' => 'Hill',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Maria',
                'LastName' => 'Hill',
                'EmailAddress' => 'maria@example.test',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Employees' => [[
                'EmployeeID' => 'employee-2',
                'FirstName' => 'Maria',
                'LastName' => 'Hill',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $employees = $client->accounting()->employees()
            ->modifiedSince(new DateTimeImmutable('2026-03-25T00:00:00+00:00'))
            ->where('Status == :status', status: 'ACTIVE')
            ->orderBy('LastName')
            ->get();

        $employee = $client->accounting()->employees()->find('employee-1');

        $created = $client->accounting()->employees()->create()
            ->firstName('Maria')
            ->lastName('Hill')
            ->save();

        $updated = $created->email('maria@example.test')->save();

        $client->accounting()->employees()->update('employee-2')
            ->firstName('Maria')
            ->idempotencyKey('employee-key')
            ->save();

        self::assertSame('/api.xro/2.0/Employees', $transport->requests()[0]->path);
        self::assertSame('Status == "ACTIVE"', $transport->requests()[0]->query['where']);
        self::assertSame('LastName ASC', $transport->requests()[0]->query['order']);
        self::assertSame('Wed, 25 Mar 2026 00:00:00 GMT', $transport->requests()[0]->query['If-Modified-Since']);
        self::assertNotNull($employees->first());
        self::assertSame('/api.xro/2.0/Employees/employee-1', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/Employees', $transport->requests()[2]->path);
        $json3 = $transport->requests()[3]->json ?? [];
        $emp3 = Json::extractFirst($json3, 'Employees');
        self::assertNotNull($emp3);
        self::assertSame('/api.xro/2.0/Employees', $transport->requests()[3]->path);
        self::assertSame('employee-2', $emp3['EmployeeID']);
        self::assertSame('maria@example.test', $updated->getEmailAddress());
        self::assertSame('employee-1', $employee?->getEmployeeID());
        self::assertSame('Nick', $employee->getFirstName());
        self::assertSame('Fury', $employee->getLastName());
        self::assertSame('ACTIVE', $employee->getStatus());
        self::assertSame('Website', $employee->getExternalLink()?->getLinkType());
        self::assertSame('https://example.test/nick-fury', $employee->getExternalLink()->getUrl());
        self::assertSame('Profile', $employee->getExternalLink()->getDescription());
        self::assertSame('2026-03-25T00:00:00', $employee->getUpdatedDateUTC());
        self::assertSame('ERROR', $employee->getStatusAttributeString());
        self::assertSame('Invalid status', $employee->getValidationErrors()[0]->getMessage());
        self::assertSame('/api.xro/2.0/Employees', $transport->requests()[4]->path);
        self::assertSame('employee-key', $transport->requests()[4]->headers['Idempotency-Key']);
        self::assertNotSame([], $client->accounting()->employees()->scopes()->broad);

        $model = (new Employee())->firstName('Phil')->lastName('Coulson');
        self::assertSame('Phil', $model->getFirstName());
        self::assertSame('Coulson', $model->getLastName());
    }

    public function test_saving_an_employee_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('without a bound client context');

        (new Employee())->firstName('Phil')->save();
    }
}
