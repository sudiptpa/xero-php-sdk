<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Item;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private Item $item;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
        $this->item = new Item($client);
    }

    public function id(string $itemId): self
    {
        $clone = clone $this;
        $clone->item = clone $this->item;
        $clone->item->setItemID($itemId);

        return $clone;
    }

    public function code(string $code): self
    {
        $clone = clone $this;
        $clone->item = clone $this->item;
        $clone->item->setCode($code);

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->item = clone $this->item;
        $clone->item->setName($name);

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->item = clone $this->item;
        $clone->item->setDescription($description);

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function using(Item $item): self
    {
        $clone = clone $this;
        $clone->item = clone $item;

        return $clone;
    }

    public function save(): Item
    {
        $response = $this->client
            ->post('/api.xro/2.0/Items')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson([
                'Items' => [$this->item->toRequest()],
            ])
            ->send();

        $payload = $response->json();
        $item = Json::extractFirst($payload, 'Items') ?? [];

        return (new Items($this->client))->mapItem($item);
    }
}
