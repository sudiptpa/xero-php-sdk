<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Client;

final class Draft
{
    /**
     * @var list<array<string, mixed>>
     */
    private array $lineItems = [];

    private string $status = 'DRAFT';

    private ?string $contactId = null;

    private ?string $reference = null;

    private string $type = 'ACCREC';

    private ?string $invoiceId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function draft(): self
    {
        $clone = clone $this;
        $clone->status = 'DRAFT';

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->contactId = $contactId;

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->type = strtoupper($type);

        return $clone;
    }

    public function id(string $invoiceId): self
    {
        $clone = clone $this;
        $clone->invoiceId = $invoiceId;

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->reference = $reference;

        return $clone;
    }

    public function lineItem(
        string $description,
        int|float $quantity,
        int|float $unitAmount
    ): self {
        $clone = clone $this;
        $clone->lineItems[] = [
            'Description' => $description,
            'Quantity' => $quantity,
            'UnitAmount' => $unitAmount,
        ];

        return $clone;
    }

    public function save(): Invoice
    {
        $path = '/api.xro/2.0/Invoices';

        if ($this->invoiceId !== null) {
            $path .= '/' . $this->invoiceId;
        }

        $response = $this->client
            ->post($path)
            ->withJson([
                'Invoices' => [[
                    'Type' => $this->type,
                    'Status' => $this->status,
                    'Reference' => $this->reference,
                    'Contact' => $this->contactId === null ? null : [
                        'ContactID' => $this->contactId,
                    ],
                    'LineItems' => $this->lineItems,
                ]],
            ])
            ->send();

        $payload = $response->json();
        $invoice = $payload['Invoices'][0] ?? [];

        return Invoice::fromArray(is_array($invoice) ? $invoice : [], $this->client);
    }
}
