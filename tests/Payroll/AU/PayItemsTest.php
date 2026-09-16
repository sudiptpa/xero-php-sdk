<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Payroll\AU;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Payroll\AU\PayItem\PayItem;
use Sujip\Xero\Xero;

final class PayItemsTest extends TestCase
{
    public function test_it_creates_pay_items_with_qualifying_earnings_and_nested_fields(): void
    {
        $rates = [[
            'Name' => 'Ordinary hours',
            'AccountCode' => '477',
            'EarningsType' => 'ORDINARYTIMEEARNINGS',
            'RateType' => 'RATEPERUNIT',
            'TypeOfUnits' => 'Hours',
            'RatePerUnit' => 0,
            'IsQualifyingEarnings' => true,
            'IsExemptFromSuper' => false,
            'IsExemptFromTax' => false,
        ]];
        $deductions = [['Name' => 'Union fee', 'AccountCode' => '826', 'ReducesTax' => false]];
        $leave = [['Name' => 'Annual leave', 'TypeOfUnits' => 'Hours', 'IsPaidLeave' => true]];
        $reimbursements = [['Name' => 'Travel', 'AccountCode' => '850']];
        $expected = [
            'EarningsRates' => $rates,
            'DeductionTypes' => $deductions,
            'LeaveTypes' => $leave,
            'ReimbursementTypes' => $reimbursements,
        ];
        $transport = (new FakeTransport())
            ->push(new Response(200, body: json_encode(['PayItems' => $expected], JSON_THROW_ON_ERROR)))
            ->push(new Response(200, body: '{"PayItems":[]}'));
        $base = Xero::withAccessToken('token', $transport)->tenant('tenant-1')
            ->payroll()->au()->payItems()->create()->earningsRates($rates);
        $saved = $base->deductionTypes($deductions)->leaveTypes($leave)
            ->reimbursementTypes($reimbursements)->idempotencyKey('pay-items-1')->save();
        $base->save();

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/payroll.xro/1.0/PayItems', $request->path);
        self::assertSame('pay-items-1', $request->headers['Idempotency-Key']);
        self::assertSame($expected, $request->json);
        self::assertSame($rates, $saved->getEarningsRates());
        self::assertSame($deductions, $saved->getDeductionTypes());
        self::assertSame($leave, $saved->getLeaveTypes());
        self::assertSame($reimbursements, $saved->getReimbursementTypes());
        self::assertSame(['EarningsRates' => $rates], $transport->requests()[1]->json);
        self::assertArrayNotHasKey('Idempotency-Key', $transport->requests()[1]->headers);
    }

    public function test_it_can_query_pay_items(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'PayItems' => [
                'EarningsRates' => [['Name' => 'Ordinary Hours']],
                'LeaveTypes' => [['Name' => 'Annual Leave']],
            ],
        ], JSON_THROW_ON_ERROR)));

        $items = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payItems()
            ->modifiedSince(new DateTimeImmutable('2026-03-26T00:00:00+00:00'))
            ->where('Status=="ACTIVE"')
            ->orderBy('Name ASC')
            ->page(2)
            ->get();

        self::assertSame('/payroll.xro/1.0/PayItems', $transport->requests()[0]->path);
        self::assertSame('Status=="ACTIVE"', $transport->requests()[0]->query['where']);
        self::assertSame('Name ASC', $transport->requests()[0]->query['order']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertInstanceOf(PayItem::class, $items->first());
        self::assertSame('Ordinary Hours', $items->first()->getEarningsRates()[0]['Name']);
        self::assertSame('Annual Leave', $items->first()->getLeaveTypes()[0]['Name']);
        self::assertSame('2026-03-26T00:00:00+00:00', $transport->requests()[0]->headers['If-Modified-Since']);
        self::assertArrayNotHasKey('If-Modified-Since', $transport->requests()[0]->query);
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payItems();

        $scopes = $resource->scopes();

        self::assertSame(['payroll.settings'], $scopes->broad);
        self::assertSame(['payroll.settings.read', 'payroll.settings'], $scopes->granular);
    }

    public function test_it_can_paginate_pay_items(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['PayItems' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->payroll()
            ->au()
            ->payItems()
            ->paginate(page: 2, perPage: 25);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(25, $page->perPage);
    }

    public function test_pay_item_exposes_all_collections(): void
    {
        $payItem = (new PayItem())->fill([
            'EarningsRates' => [['Name' => 'Ordinary Hours']],
            'DeductionTypes' => [['Name' => 'Union Fee']],
            'LeaveTypes' => [['Name' => 'Annual Leave']],
            'ReimbursementTypes' => [['Name' => 'Mileage']],
        ]);

        self::assertSame('Ordinary Hours', $payItem->getEarningsRates()[0]['Name']);
        self::assertSame('Union Fee', $payItem->getDeductionTypes()[0]['Name']);
        self::assertSame('Annual Leave', $payItem->getLeaveTypes()[0]['Name']);
        self::assertSame('Mileage', $payItem->getReimbursementTypes()[0]['Name']);
    }
}
