<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $creditNoteId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $creditNoteId): self
    {
        $clone = clone $this;
        $clone->creditNoteId = $creditNoteId;

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

    public function save(): CreditNote
    {
        if ($this->creditNoteId !== null) {
            $this->payload['CreditNoteID'] = $this->creditNoteId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/CreditNotes')
            ->withJson(['CreditNotes' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $creditNote = $payload['CreditNotes'][0] ?? [];

        return CreditNote::fromArray(is_array($creditNote) ? $creditNote : [], $this->client);
    }
}
