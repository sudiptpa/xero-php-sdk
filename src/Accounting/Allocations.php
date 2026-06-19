<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final readonly class Allocations
{
    public function __construct(
        private Client $client,
        private string $path
    ) {
    }

    public function create(string $invoiceId, float $amount, string $date, ?string $idempotencyKey = null): Allocation
    {
        $payload = $this->client
            ->put($this->path)
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson([
                'Allocations' => [[
                    'Invoice' => [
                        'InvoiceID' => $invoiceId,
                    ],
                    'Amount' => $amount,
                    'Date' => $date,
                ]],
            ])
            ->send()
            ->json();

        $allocation = Json::extractFirst($payload, 'Allocations') ?? [];

        return (new Allocation())->fill($allocation);
    }

    public function delete(string $allocationId): Allocation
    {
        $payload = $this->client
            ->delete($this->path . '/' . $allocationId)
            ->send()
            ->json();

        // The delete response is a bare Allocation object, not a wrapped list.
        $allocation = Json::extractFirst($payload, 'Allocations') ?? $payload;

        return (new Allocation())->fill($allocation);
    }
}
