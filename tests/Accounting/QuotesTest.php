<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\Quote\Quote;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
                'Contact' => [
                    'ContactID' => 'contact-1',
                    'Name' => 'Acme Client',
                ],
                'LineItems' => [[
                    'Description' => 'Design sprint',
                    'Quantity' => 1,
                    'UnitAmount' => 1200,
                ]],
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
        $firstQuote = $quotes->first();
        self::assertNotNull($firstQuote);
        self::assertSame('/api.xro/2.0/Quotes/quote-1', $transport->requests()[1]->path);
        self::assertSame('quote-1', $quote?->getQuoteID());
        self::assertSame('contact-1', $firstQuote->getContact()?->getContactID());
        self::assertSame('Design sprint', $firstQuote->getLineItems()[0]->getDescription());
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
            ->using(
                (new Quote())
                    ->setContact(
                        (new Contact())
                            ->setContactID('contact-1')
                    )
                    ->setTitle('Website redesign')
                    ->addLineItem(
                        (new LineItem())
                            ->setDescription('Design sprint')
                            ->setQuantity(1)
                            ->setUnitAmount(1200)
                    )
            )
            ->save();

        $updated = $created->title('Website redesign phase 2')->save();

        self::assertSame('/api.xro/2.0/Quotes', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        $q0 = Json::extractFirst($json0, 'Quotes');
        self::assertNotNull($q0);
        self::assertSame('contact-1', Json::extractObject($q0, 'Contact')['ContactID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $q1 = Json::extractFirst($json1, 'Quotes');
        self::assertNotNull($q1);
        self::assertSame('/api.xro/2.0/Quotes', $transport->requests()[1]->path);
        self::assertSame('quote-1', $q1['QuoteID']);
        self::assertSame('Website redesign phase 2', $updated->getTitle());
    }

    public function test_it_exposes_scopes(): void
    {
        $resource = Xero::withAccessToken('token', new FakeTransport())
            ->tenant('tenant-123')
            ->accounting()
            ->quotes();

        $scopes = $resource->scopes();

        self::assertSame(['accounting.transactions'], $scopes->broad);
        self::assertSame(['accounting.transactions.read', 'accounting.transactions'], $scopes->granular);
    }

    public function test_it_can_paginate_quotes(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode(['Quotes' => []], JSON_THROW_ON_ERROR))
        );

        $page = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->quotes()
            ->paginate(page: 2, perPage: 30);

        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(30, $transport->requests()[0]->query['pageSize']);
        self::assertSame(2, $page->page);
        self::assertSame(30, $page->perPage);
    }

    public function test_payload_builder_methods_compose_the_request(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Quotes' => [['QuoteID' => 'quote-1']],
            ], JSON_THROW_ON_ERROR))
        );

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->quotes()
            ->update('quote-1')
            ->contact('contact-1')
            ->title('Website redesign')
            ->lineItem('Design sprint', 1, 1200)
            ->save();

        $json = $transport->requests()[0]->json ?? [];
        $quote = Json::extractFirst($json, 'Quotes');
        self::assertNotNull($quote);
        self::assertSame('quote-1', $quote['QuoteID']);
        self::assertSame('contact-1', Json::extractObject($quote, 'Contact')['ContactID']);
        self::assertSame('Website redesign', $quote['Title']);
        $lineItems = Json::extractList($quote, 'LineItems');
        self::assertSame('Design sprint', $lineItems[0]['Description'] ?? null);
    }

    public function test_model_fluent_helpers_set_fields(): void
    {
        $quote = (new Quote())
            ->title('Website redesign')
            ->contact('contact-9')
            ->lineItem('Design sprint', 1, 1200)
            ->setLineItems([
                (new LineItem())->setDescription('Replaced'),
            ]);

        self::assertSame('Website redesign', $quote->getTitle());
        self::assertSame('contact-9', $quote->getContact()?->getContactID());
        self::assertSame('Replaced', $quote->getLineItems()[0]->getDescription());
    }

    public function test_bound_model_exposes_pdf(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Quotes' => [['QuoteID' => 'quote-1']],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: '%PDF-1.4 quote'));

        $quote = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->quotes()
            ->find('quote-1');

        self::assertNotNull($quote);
        $pdf = $quote->pdf();

        self::assertSame('%PDF-1.4 quote', $pdf);
        self::assertSame('/api.xro/2.0/Quotes/quote-1/pdf', $transport->requests()[1]->path);
    }

    public function test_saving_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Quote())->save();
    }

    public function test_pdf_without_a_client_throws(): void
    {
        $this->expectException(\RuntimeException::class);

        (new Quote())->pdf();
    }
}
