<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ExpenseClaim;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

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
        $receipts = is_array($clone->payload['Receipts'] ?? null) ? $clone->payload['Receipts'] : [];
        $receipts[] = ['ReceiptID' => $receiptId];
        $clone->payload['Receipts'] = $receipts;

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
        $expenseClaim = Json::extractFirst($payload, 'ExpenseClaims') ?? [];

        return (new ExpenseClaims($this->client))
            ->mapExpenseClaim($expenseClaim);
    }
}
