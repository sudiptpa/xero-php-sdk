<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

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
        $lineItems = is_array($clone->payload['LineItems'] ?? null) ? $clone->payload['LineItems'] : [];
        $lineItems[] = [
            'Description' => $description,
            'Quantity' => $quantity,
            'UnitAmount' => $unitAmount,
        ];
        $clone->payload['LineItems'] = $lineItems;

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
        $repeatingInvoice = Json::extractFirst($payload, 'RepeatingInvoices') ?? [];

        return (new RepeatingInvoices($this->client))
            ->mapRepeatingInvoice($repeatingInvoice);
    }
}
