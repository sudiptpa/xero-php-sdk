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
}
