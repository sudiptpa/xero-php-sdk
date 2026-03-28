<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

use Sujip\Xero\Client;

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
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function accountCode(string $accountCode): self
    {
        $clone = clone $this;
        $clone->payload['AccountCode'] = $accountCode;

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

        /** @var array<string, mixed>|null $reimbursement */
        $reimbursement = $payload['Reimbursements'][0] ?? $payload['Reimbursement'] ?? null;

        if (! is_array($reimbursement)) {
            return new Reimbursement();
        }

        return (new Settings($this->client))->mapReimbursement($reimbursement);
    }
}
