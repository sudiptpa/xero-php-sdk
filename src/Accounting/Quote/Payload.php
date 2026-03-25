<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Quote;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $quoteId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $quoteId): self
    {
        $clone = clone $this;
        $clone->quoteId = $quoteId;

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->payload['Contact'] = ['ContactID' => $contactId];

        return $clone;
    }

    public function title(string $title): self
    {
        $clone = clone $this;
        $clone->payload['Title'] = $title;

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $clone = clone $this;
        $clone->payload['LineItems'] ??= [];
        $clone->payload['LineItems'][] = [
            'Description' => $description,
            'Quantity' => $quantity,
            'UnitAmount' => $unitAmount,
        ];

        return $clone;
    }

    public function save(): Quote
    {
        if ($this->quoteId !== null) {
            $this->payload['QuoteID'] = $this->quoteId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/Quotes')
            ->withJson(['Quotes' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $quote = $payload['Quotes'][0] ?? [];

        return Quote::fromArray(is_array($quote) ? $quote : [], $this->client);
    }
}
