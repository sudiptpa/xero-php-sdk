<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $repeatingInvoiceId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $repeatingInvoiceId): self
    {
        $clone = clone $this;
        $clone->repeatingInvoiceId = $repeatingInvoiceId;

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->payload['Type'] = strtoupper($type);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->payload['Contact'] = ['ContactID' => $contactId];

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->payload['Reference'] = $reference;

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

    public function save(): RepeatingInvoice
    {
        if ($this->repeatingInvoiceId !== null) {
            $this->payload['RepeatingInvoiceID'] = $this->repeatingInvoiceId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/RepeatingInvoices')
            ->withJson(['RepeatingInvoices' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $repeatingInvoice = $payload['RepeatingInvoices'][0] ?? [];

        return RepeatingInvoice::fromArray(is_array($repeatingInvoice) ? $repeatingInvoice : [], $this->client);
    }
}
