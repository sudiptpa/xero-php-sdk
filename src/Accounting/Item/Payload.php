<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Item;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $itemId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $itemId): self
    {
        $clone = clone $this;
        $clone->itemId = $itemId;

        return $clone;
    }

    public function code(string $code): self
    {
        $clone = clone $this;
        $clone->payload['Code'] = $code;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->payload['Description'] = $description;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Item
    {
        if ($this->itemId !== null) {
            $this->payload['ItemID'] = $this->itemId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/Items')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson([
                'Items' => [$this->payload],
            ])
            ->send();

        $payload = $response->json();
        $item = $payload['Items'][0] ?? [];

        return Item::fromArray(is_array($item) ? $item : [], $this->client);
    }
}
