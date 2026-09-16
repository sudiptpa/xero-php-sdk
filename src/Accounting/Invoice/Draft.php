<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Draft
{
    private Invoice $invoice;

    private ?bool $allowBackorders = null;

    private ?int $unitDp = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
        $this->invoice = (new Invoice($client))
            ->setType('ACCREC')
            ->setStatus('DRAFT');
    }

    public function draft(): self
    {
        $clone = clone $this;
        $clone->invoice = clone $this->invoice;
        $clone->invoice->setStatus('DRAFT');

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->invoice = clone $this->invoice;
        $clone->invoice->setContactID($contactId);

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->invoice = clone $this->invoice;
        $clone->invoice->setType($type);

        return $clone;
    }

    public function id(string $invoiceId): self
    {
        $clone = clone $this;
        $clone->invoice = clone $this->invoice;
        $clone->invoice->setInvoiceID($invoiceId);

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->invoice = clone $this->invoice;
        $clone->invoice->setReference($reference);

        return $clone;
    }

    public function lineItem(
        string $description,
        int|float $quantity,
        int|float $unitAmount
    ): self {
        $clone = clone $this;
        $clone->invoice = clone $this->invoice;
        $clone->invoice->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );

        return $clone;
    }

    public function using(Invoice $invoice): self
    {
        $clone = clone $this;
        $clone->invoice = clone $invoice;

        return $clone;
    }

    public function save(): Invoice
    {
        $path = '/api.xro/2.0/Invoices';

        if ($this->invoice->getInvoiceID() !== null) {
            $path .= '/' . $this->invoice->getInvoiceID();
        }

        $response = $this->client
            ->post($path)
            ->withQuery(array_filter([
                'allowBackorders' => $this->allowBackorders === null ? null : ($this->allowBackorders ? 'true' : 'false'),
                'unitdp' => $this->unitDp,
            ], static fn (mixed $value): bool => $value !== null))
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson([
                'Invoices' => [$this->invoice->toRequest()],
            ])
            ->send();

        $payload = $response->json();
        $invoice = Json::extractFirst($payload, 'Invoices') ?? [];

        return (new Invoices($this->client))
            ->mapInvoice($invoice);
    }

    public function allowBackorders(bool $allow = true): self
    {
        $clone = clone $this;
        $clone->allowBackorders = $allow;

        return $clone;
    }

    public function unitDp(int $unitDp): self
    {
        $clone = clone $this;
        $clone->unitDp = $unitDp;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }
}
