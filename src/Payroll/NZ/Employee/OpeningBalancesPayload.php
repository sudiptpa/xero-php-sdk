<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;

final class OpeningBalancesPayload
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

    public function periodEndDate(string $periodEndDate): self
    {
        $clone = clone $this;
        $clone->payload['periodEndDate'] = $periodEndDate;

        return $clone;
    }

    public function daysPaid(int|float $daysPaid): self
    {
        $clone = clone $this;
        $clone->payload['daysPaid'] = $daysPaid;

        return $clone;
    }

    public function unpaidWeeks(int $unpaidWeeks): self
    {
        $clone = clone $this;
        $clone->payload['unpaidWeeks'] = $unpaidWeeks;

        return $clone;
    }

    public function grossEarnings(int|float $grossEarnings): self
    {
        $clone = clone $this;
        $clone->payload['grossEarnings'] = $grossEarnings;

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
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/OpeningBalances')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
