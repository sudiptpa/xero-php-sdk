<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Quote;

use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private Quote $quote;

    public function __construct(
        private readonly Client $client
    ) {
        $this->quote = new Quote($client);
    }

    public function id(string $quoteId): self
    {
        $clone = clone $this;
        $clone->quote = clone $this->quote;
        $clone->quote->setQuoteID($quoteId);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->quote = clone $this->quote;
        $clone->quote->setContact(
            (new Contact())
                ->setContactID($contactId)
        );

        return $clone;
    }

    public function title(string $title): self
    {
        $clone = clone $this;
        $clone->quote = clone $this->quote;
        $clone->quote->setTitle($title);

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $clone = clone $this;
        $clone->quote = clone $this->quote;
        $clone->quote->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );

        return $clone;
    }

    public function using(Quote $quote): self
    {
        $clone = clone $this;
        $clone->quote = clone $quote;

        return $clone;
    }

    public function save(): Quote
    {
        $response = $this->client
            ->post('/api.xro/2.0/Quotes')
            ->withJson(['Quotes' => [$this->quote->toRequest()]])
            ->send();

        $payload = $response->json();
        $quote = Json::extractFirst($payload, 'Quotes') ?? [];

        return (new Quotes($this->client))
            ->mapQuote($quote);
    }
}
