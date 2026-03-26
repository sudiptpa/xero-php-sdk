<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayRun;

use Sujip\Xero\Client;

final class Payload
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

    public function payrollCalendar(string $payrollCalendarId): self
    {
        $clone = clone $this;
        $clone->payload['PayrollCalendarID'] = $payrollCalendarId;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): PayRun
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/PayRuns')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['PayRun' => $this->payload])
            ->send();

        $payload = $response->json();
        $payRun = $payload['PayRuns'][0] ?? $payload['PayRun'] ?? [];

        return PayRun::fromArray(is_array($payRun) ? $payRun : []);
    }
}
