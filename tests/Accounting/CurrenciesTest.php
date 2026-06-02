<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Currency\Currency;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class CurrenciesTest extends TestCase
{
    public function test_it_can_list_and_create_currencies(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Currencies' => [[
                'Code' => 'USD',
                'Description' => 'United States Dollar',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Currencies' => [[
                'Code' => 'EUR',
                'Description' => 'Euro',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $currencies = $client->accounting()->currencies()->get();
        $created = $client->accounting()->currencies()->create()
            ->code('EUR')
            ->description('Euro')
            ->idempotencyKey('currency-key')
            ->save();

        self::assertSame('/api.xro/2.0/Currencies', $transport->requests()[0]->path);
        self::assertNotNull($currencies->first());
        self::assertSame('/api.xro/2.0/Currencies', $transport->requests()[1]->path);
        self::assertSame('currency-key', $transport->requests()[1]->headers['Idempotency-Key']);
        $json1 = $transport->requests()[1]->json ?? [];
        self::assertSame('EUR', $json1['Code'] ?? null);
        self::assertSame('EUR', $created->getCode());
    }
}
