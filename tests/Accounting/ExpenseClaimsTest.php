<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\ExpenseClaim\ExpenseClaim;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ExpenseClaimsTest extends TestCase
{
    public function test_it_can_query_find_create_and_update_expense_claims(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'ExpenseClaims' => [[
                'ExpenseClaimID' => 'expense-1',
                'Status' => 'SUBMITTED',
                'Total' => 80,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ExpenseClaims' => [[
                'ExpenseClaimID' => 'expense-1',
                'Status' => 'SUBMITTED',
                'Total' => 80,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ExpenseClaims' => [[
                'ExpenseClaimID' => 'expense-2',
                'Status' => 'DRAFT',
                'Employee' => ['EmployeeID' => 'employee-1'],
                'Receipts' => [['ReceiptID' => 'receipt-1']],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ExpenseClaims' => [[
                'ExpenseClaimID' => 'expense-2',
                'Status' => 'SUBMITTED',
                'Employee' => ['EmployeeID' => 'employee-1'],
                'Receipts' => [['ReceiptID' => 'receipt-1']],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $claims = $client->accounting()->expenseClaims()->where('Status == :status', status: 'SUBMITTED')->get();
        $claim = $client->accounting()->expenseClaims()->find('expense-1');
        $created = $client->accounting()->expenseClaims()->create()
            ->employee('employee-1')
            ->receipt('receipt-1')
            ->status('DRAFT')
            ->save();
        $updated = $created->status('SUBMITTED')->save();

        self::assertSame('/api.xro/2.0/ExpenseClaims', $transport->requests()[0]->path);
        self::assertSame('Status == "SUBMITTED"', $transport->requests()[0]->query['where']);
        self::assertInstanceOf(ExpenseClaim::class, $claims->first());
        self::assertSame('/api.xro/2.0/ExpenseClaims/expense-1', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/ExpenseClaims', $transport->requests()[2]->path);
        self::assertSame('employee-1', $transport->requests()[2]->json['ExpenseClaims'][0]['Employee']['EmployeeID']);
        self::assertSame('/api.xro/2.0/ExpenseClaims', $transport->requests()[3]->path);
        self::assertSame('expense-2', $transport->requests()[3]->json['ExpenseClaims'][0]['ExpenseClaimID']);
        self::assertSame('SUBMITTED', $updated->status);
        self::assertSame('expense-1', $claim?->id);
    }
}
