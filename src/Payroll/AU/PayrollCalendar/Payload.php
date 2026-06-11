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

        $calendar = Json::extractFirst($payload, 'PayrollCalendars') ?? Json::extractObject($payload, 'PayrollCalendar') ?: null;

        if ($calendar === null) {
            return new PayrollCalendar();
        }

        return (new PayrollCalendars($this->client))->mapPayrollCalendar($calendar);
    }
}
