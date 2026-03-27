<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Finance;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Finance\CashValidation\CashValidationResult;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class CashValidationTest extends TestCase
{
    public function test_it_can_get_cash_validation(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'CashValidation' => [
                'Status' => 'OK',
                'Balance' => 1000.50,
                'Currency' => 'GBP',
            ],
        ], JSON_THROW_ON_ERROR)));

        $result = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->finance()
            ->cashValidation()
            ->get(new DateTimeImmutable('2026-03-31'));

        self::assertSame('/finance.xro/1.0/CashValidation', $transport->requests()[0]->path);
        self::assertSame('2026-03-31', $transport->requests()[0]->query['balanceDate']);
        self::assertInstanceOf(CashValidationResult::class, $result);
        self::assertSame('OK', $result->status);
    }
}
