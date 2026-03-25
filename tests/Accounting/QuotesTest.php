<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Quote\Quote;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class QuotesTest extends TestCase
{
    public function test_it_can_query_and_find_quotes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Quotes' => [[
                'QuoteID' => 'quote-1',
                'QuoteNumber' => 'QUO-1001',
                'Status' => 'DRAFT',
                'Title' => 'Website redesign',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Quotes' => [[
                'QuoteID' => 'quote-1',
                'QuoteNumber' => 'QUO-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $quotes = $client->accounting()->quotes()->where('Status == :status', status: 'DRAFT')->get();
        $quote = $client->accounting()->quotes()->find('quote-1');

        self::assertSame('/api.xro/2.0/Quotes', $transport->requests()[0]->path);
        self::assertInstanceOf(Quote::class, $quotes->first());
        self::assertSame('/api.xro/2.0/Quotes/quote-1', $transport->requests()[1]->path);
        self::assertSame('quote-1', $quote?->id);
    }

    public function test_it_can_create_and_update_quotes(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Quotes' => [[
                'QuoteID' => 'quote-1',
                'Title' => 'Website redesign',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Quotes' => [[
                'QuoteID' => 'quote-1',
                'Title' => 'Website redesign phase 2',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->quotes()->create()
            ->contact('contact-1')
            ->title('Website redesign')
            ->lineItem('Design sprint', 1, 1200)
            ->save();

        $updated = $created->title('Website redesign phase 2')->save();

        self::assertSame('/api.xro/2.0/Quotes', $transport->requests()[0]->path);
        self::assertSame('contact-1', $transport->requests()[0]->json['Quotes'][0]['Contact']['ContactID']);
        self::assertSame('/api.xro/2.0/Quotes', $transport->requests()[1]->path);
        self::assertSame('quote-1', $transport->requests()[1]->json['Quotes'][0]['QuoteID']);
        self::assertSame('Website redesign phase 2', $updated->title);
    }
}
