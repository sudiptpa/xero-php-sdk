<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Settings;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Headers;
use Sujip\Xero\Support\Json;

final class ReimbursementPayload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['name'] = $name;

        return $clone;
    }

    public function account(string $accountId): self
    {
        $clone = clone $this;
        $clone->payload['accountID'] = $accountId;

        return $clone;
    }

    public function category(string $category): self
    {
        $clone = clone $this;
        $clone->payload['reimbursementCategory'] = $category;

        return $clone;
    }

    public function calculationType(string $calculationType): self
    {
        $clone = clone $this;
        $clone->payload['calculationType'] = $calculationType;

        return $clone;
    }

    public function standardAmount(string $standardAmount): self
    {
        $clone = clone $this;
        $clone->payload['standardAmount'] = $standardAmount;

        return $clone;
    }

    public function standardTypeOfUnits(string $standardTypeOfUnits): self
    {
        $clone = clone $this;
        $clone->payload['standardTypeOfUnits'] = $standardTypeOfUnits;

        return $clone;
    }

    public function standardRatePerUnit(float $standardRatePerUnit): self
    {
        $clone = clone $this;
        $clone->payload['standardRatePerUnit'] = $standardRatePerUnit;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Reimbursement
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/Reimbursements')
            ->withHeaders(Headers::idempotency($this->idempotencyKey))
            ->withJson($this->payload)
            ->send()
            ->json();

        $reimbursement = Json::extractObject($payload, 'reimbursement');

        return $reimbursement !== [] ? (new Settings($this->client))->mapReimbursement($reimbursement) : new Reimbursement();
    }
}
