<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $payRunId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $payRunId): self
    {
        $clone = clone $this;
        $clone->payRunId = $payRunId;

        return $clone;
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
        $request = $this->payRunId === null
            ? $this->client->post('/payroll.xro/1.0/PayRuns')
            : $this->client->post('/payroll.xro/1.0/PayRuns/' . $this->payRunId);

        if ($this->payRunId !== null) {
            $this->payload['PayRunID'] = $this->payRunId;
        }

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['PayRuns' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $payRun = $payload['PayRuns'][0] ?? $payload['PayRun'] ?? [];

        if (! is_array($payRun)) {
            return new PayRun($this->client);
        }

        return (new PayRuns($this->client))->mapPayRun($payRun);
    }
}
