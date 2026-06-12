<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class SetupTest extends TestCase
{
    public function test_it_posts_a_conversion_setup(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'ImportSummary' => [
                'Accounts' => ['Total' => 17, 'New' => 2, 'Updated' => 8],
                'Organisation' => ['Present' => false],
            ],
        ], JSON_THROW_ON_ERROR)));

        $summary = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->setup()
            ->conversionDate(9, 2025)
            ->conversionBalance('200', 100.5)
            ->account((new Account())->setCode('200')->setName('Sales')->setType('SALES'))
            ->idempotencyKey('setup-key')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Setup', $request->path);
        self::assertSame('setup-key', $request->headers['Idempotency-Key']);

        $json = $request->json ?? [];
        self::assertSame(['Month' => 9, 'Year' => 2025], $json['ConversionDate'] ?? null);
        self::assertSame([['AccountCode' => '200', 'Balance' => 100.5]], $json['ConversionBalances'] ?? null);
        $accounts = $json['Accounts'] ?? [];
        self::assertIsArray($accounts);
        self::assertCount(1, $accounts);
        $firstAccount = $accounts[0];
        self::assertIsArray($firstAccount);
        self::assertSame('200', $firstAccount['Code'] ?? null);

        self::assertSame(17, $summary->accounts['Total']);
        self::assertSame(['Present' => false], $summary->organisation);
        self::assertArrayHasKey('Accounts', $summary->raw);
    }

    public function test_an_empty_conversion_date_is_sent_as_an_object(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $summary = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->setup()
            ->save();

        $request = $transport->requests()[0];
        self::assertArrayNotHasKey('Idempotency-Key', $request->headers);
        self::assertInstanceOf(\stdClass::class, ($request->json ?? [])['ConversionDate'] ?? null);
        self::assertSame([], $summary->accounts);
        self::assertSame([], $summary->organisation);
    }
}
