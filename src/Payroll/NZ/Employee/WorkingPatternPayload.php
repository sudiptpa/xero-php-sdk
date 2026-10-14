<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\Employee;

use Sujip\Xero\Client;

final class WorkingPatternPayload
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

    public function effectiveFrom(string $effectiveFrom): self
    {
        $clone = clone $this;
        $clone->payload['effectiveFrom'] = $effectiveFrom;

        return $clone;
    }

    public function workingWeek(
        float $monday,
        float $tuesday,
        float $wednesday,
        float $thursday,
        float $friday,
        float $saturday,
        float $sunday,
    ): self {
        $clone = clone $this;

        /** @var list<array<string, float>> $workingWeeks */
        $workingWeeks = is_array($clone->payload['workingWeeks'] ?? null) ? $clone->payload['workingWeeks'] : [];
        $workingWeeks[] = [
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
            'sunday' => $sunday,
        ];
        $clone->payload['workingWeeks'] = $workingWeeks;

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
            ->post('/payroll.xro/2.0/Employees/' . $this->employeeId . '/Working-Patterns')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->payload)
            ->send()
            ->json();
    }
}
