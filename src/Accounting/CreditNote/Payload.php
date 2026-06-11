<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private CreditNote $creditNote;

    public function __construct(
        private readonly Client $client
    ) {
        $this->creditNote = new CreditNote($client);
    }

    public function id(string $creditNoteId): self
    {
        $clone = clone $this;
        $clone->creditNote = clone $this->creditNote;
        $clone->creditNote->setCreditNoteID($creditNoteId);

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->creditNote = clone $this->creditNote;
        $clone->creditNote->setType($type);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->creditNote = clone $this->creditNote;
        $clone->creditNote->setContact(
            (new Contact())
                ->setContactID($contactId)
        );

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->creditNote = clone $this->creditNote;
        $clone->creditNote->setReference($reference);

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $clone = clone $this;
        $clone->creditNote = clone $this->creditNote;
        $clone->creditNote->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );

        return $clone;
    }

    public function using(CreditNote $creditNote): self
    {
        $clone = clone $this;
        $clone->creditNote = clone $creditNote;

        return $clone;
    }

    public function save(): CreditNote
    {
        $response = $this->client
            ->post('/api.xro/2.0/CreditNotes')
            ->withJson(['CreditNotes' => [$this->creditNote->toRequest()]])
            ->send();

        $payload = $response->json();
        $creditNote = Json::extractFirst($payload, 'CreditNotes') ?? [];

        return (new CreditNotes($this->client))
            ->mapCreditNote($creditNote);
    }
}
