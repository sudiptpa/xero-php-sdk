<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;

final class PaymentMethodPayload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $employeeId
    ) {
    }

    public function bankAccount(
        string $accountName,
        string $accountNumber,
        string $sortCode,
        ?string $particulars = null,
        ?string $code = null,
        ?float $dollarAmount = null,
        ?string $reference = null,
        ?string $calculationType = null,
    ): self {
        $clone = clone $this;

        /** @var list<array<string, mixed>> $bankAccounts */
        $bankAccounts = is_array($clone->payload['bankAccounts'] ?? null) ? $clone->payload['bankAccounts'] : [];
        $bankAccounts[] = array_filter([
            'accountName' => $accountName,
            'accountNumber' => $accountNumber,
            'sortCode' => $sortCode,
            'particulars' => $particulars,
            'code' => $code,
            'dollarAmount' => $dollarAmount,
            'reference' => $reference,
            'calculationType' => $calculationType,
        ], static fn (mixed $value): bool => $value !== null);
        $clone->payload['bankAccounts'] = $bankAccounts;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    /**
     * @return array<string, mixed>
     */
    public function save(): array
    {
        return $this->client
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/PaymentMethods')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
