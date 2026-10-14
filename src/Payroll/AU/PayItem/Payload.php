<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayItem;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Headers;
use Sujip\Xero\Support\Json;

/**
 * Xero treats each pay item type here as a full replace, not an append: any
 * existing record of that type left out of the array (by its ID) gets
 * deleted. Always include every existing record you want to keep alongside
 * whatever you're adding or changing.
 */
final class Payload
{
    /** @var array<string, list<array<string, mixed>>> */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(private readonly Client $client)
    {
    }

    /** @param list<array<string, mixed>> $rates */
    public function earningsRates(array $rates): self
    {
        $clone = clone $this;
        $clone->payload['EarningsRates'] = $rates;

        return $clone;
    }

    /** @param list<array<string, mixed>> $types */
    public function deductionTypes(array $types): self
    {
        $clone = clone $this;
        $clone->payload['DeductionTypes'] = $types;

        return $clone;
    }

    /** @param list<array<string, mixed>> $types */
    public function leaveTypes(array $types): self
    {
        $clone = clone $this;
        $clone->payload['LeaveTypes'] = $types;

        return $clone;
    }

    /** @param list<array<string, mixed>> $types */
    public function reimbursementTypes(array $types): self
    {
        $clone = clone $this;
        $clone->payload['ReimbursementTypes'] = $types;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): PayItem
    {
        $response = $this->client->post('/payroll.xro/1.0/PayItems')
            ->withHeaders(Headers::idempotency($this->idempotencyKey))
            ->withJson($this->payload)
            ->send();

        return (new PayItem())->fill(Json::extractObject($response->json(), 'PayItems'));
    }
}
