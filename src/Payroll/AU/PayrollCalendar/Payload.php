<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayrollCalendar;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $attributes = [];

    public function __construct(
        private readonly Client $client,
        private readonly ?string $id = null,
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

    public function save(): PayrollCalendar
    {
        $request = $this->id === null
            ? $this->client->post('/payroll.xro/1.0/PayrollCalendars')
            : $this->client->put('/payroll.xro/1.0/PayrollCalendars/' . $this->id);

        $payload = $request
            ->withJson($this->attributes)
            ->send()
            ->json();

        /** @var array<string, mixed>|null $calendar */
        $calendar = $payload['PayrollCalendars'][0] ?? $payload['PayrollCalendar'] ?? null;

        return PayrollCalendar::fromArray(is_array($calendar) ? $calendar : []);
    }
}
