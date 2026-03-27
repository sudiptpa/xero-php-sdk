<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayrollCalendar;

final readonly class PayrollCalendar
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $calendarType,
        public ?string $startDate,
        public ?string $paymentDate,
        public array $raw = [],
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['PayrollCalendarID'] ?? null,
            $payload['Name'] ?? null,
            $payload['CalendarType'] ?? null,
            $payload['StartDate'] ?? null,
            $payload['PaymentDate'] ?? null,
            $payload,
        );
    }
}
