<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayrollCalendar;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $attributes = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client,
    ) {
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->attributes['Name'] = $name;

        return $clone;
    }

    public function calendarType(string $calendarType): self
    {
        $clone = clone $this;
        $clone->attributes['CalendarType'] = $calendarType;

        return $clone;
    }

    public function startDate(string $startDate): self
    {
        $clone = clone $this;
        $clone->attributes['StartDate'] = $startDate;

        return $clone;
    }

    public function paymentDate(string $paymentDate): self
    {
        $clone = clone $this;
        $clone->attributes['PaymentDate'] = $paymentDate;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): PayrollCalendar
    {
        $payload = $this->client
            ->post('/payroll.xro/1.0/PayrollCalendars')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson($this->attributes)
            ->send()
            ->json();

        $calendar = Json::extractFirst($payload, 'PayrollCalendars') ?? Json::extractObject($payload, 'PayrollCalendar') ?: null;

        if ($calendar === null) {
            return new PayrollCalendar();
        }

        return (new PayrollCalendars($this->client))->mapPayrollCalendar($calendar);
    }
}
