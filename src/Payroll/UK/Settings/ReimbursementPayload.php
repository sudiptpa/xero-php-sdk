<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

use Sujip\Xero\Client;
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
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();

        $reimbursement = Json::extractFirst($payload, 'reimbursements') ?? Json::extractObject($payload, 'reimbursement') ?: null;

        if ($reimbursement === null) {
            return new Reimbursement();
        }

        return (new Settings($this->client))->mapReimbursement($reimbursement);
    }
}
