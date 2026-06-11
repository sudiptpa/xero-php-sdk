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
    public function test_it_can_query_pay_items(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'PayItems' => [[
                'EarningsRates' => [['Name' => 'Ordinary Hours']],
                'LeaveTypes' => [['Name' => 'Annual Leave']],
            ]],
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
            'SuperannuationTypes' => [['Name' => 'Super Guarantee']],
        ]);

        self::assertSame('Ordinary Hours', $payItem->getEarningsRates()[0]['Name']);
        self::assertSame('Union Fee', $payItem->getDeductionTypes()[0]['Name']);
        self::assertSame('Annual Leave', $payItem->getLeaveTypes()[0]['Name']);
        self::assertSame('Mileage', $payItem->getReimbursementTypes()[0]['Name']);
        self::assertSame('Super Guarantee', $payItem->getSuperannuationTypes()[0]['Name']);
    }
}
