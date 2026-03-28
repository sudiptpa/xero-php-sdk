<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Overpayment\Overpayment;
use Sujip\Xero\Accounting\Prepayment\Prepayment;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class OverpaymentsAndPrepaymentsTest extends TestCase
{
    public function test_it_can_query_and_find_overpayments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Overpayments' => [[
                'OverpaymentID' => 'over-1',
                'Type' => 'OVERPAYMENT',
                'Status' => 'AUTHORISED',
                'RemainingCredit' => 20,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Overpayments' => [[
                'OverpaymentID' => 'over-1',
                'Status' => 'AUTHORISED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $overpayments = $client->accounting()->overpayments()->where('Status == :status', status: 'AUTHORISED')->get();
        $overpayment = $client->accounting()->overpayments()->find('over-1');

        self::assertSame('/api.xro/2.0/Overpayments', $transport->requests()[0]->path);
        self::assertInstanceOf(Overpayment::class, $overpayments->first());
        self::assertSame('/api.xro/2.0/Overpayments/over-1', $transport->requests()[1]->path);
        self::assertSame('over-1', $overpayment?->getOverpaymentID());
    }

    public function test_it_can_query_and_find_prepayments(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Prepayments' => [[
                'PrepaymentID' => 'pre-1',
                'Type' => 'PREPAYMENT',
                'Status' => 'AUTHORISED',
                'RemainingCredit' => 10,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Prepayments' => [[
                'PrepaymentID' => 'pre-1',
                'Status' => 'AUTHORISED',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $prepayments = $client->accounting()->prepayments()->where('Status == :status', status: 'AUTHORISED')->get();
        $prepayment = $client->accounting()->prepayments()->find('pre-1');

        self::assertSame('/api.xro/2.0/Prepayments', $transport->requests()[0]->path);
        self::assertInstanceOf(Prepayment::class, $prepayments->first());
        self::assertSame('/api.xro/2.0/Prepayments/pre-1', $transport->requests()[1]->path);
        self::assertSame('pre-1', $prepayment?->getPrepaymentID());
    }
}
