<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ExpenseClaim;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $expenseClaimId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $expenseClaimId): self
    {
        $clone = clone $this;
        $clone->expenseClaimId = $expenseClaimId;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->payload['Status'] = $status;

        return $clone;
    }

    public function employee(string $employeeId): self
    {
        $clone = clone $this;
        $clone->payload['Employee'] = ['EmployeeID' => $employeeId];

        return $clone;
    }

    public function receipt(string $receiptId): self
    {
        $clone = clone $this;
        $clone->payload['Receipts'] ??= [];
        $clone->payload['Receipts'][] = ['ReceiptID' => $receiptId];

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): ExpenseClaim
    {
        if ($this->expenseClaimId !== null) {
            $this->payload['ExpenseClaimID'] = $this->expenseClaimId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/ExpenseClaims')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['ExpenseClaims' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $expenseClaim = $payload['ExpenseClaims'][0] ?? [];

        return ExpenseClaim::fromArray(is_array($expenseClaim) ? $expenseClaim : [], $this->client);
    }
}
