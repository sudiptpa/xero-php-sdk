<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayRunCalendar;

final readonly class PayRunCalendar
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $calendarType,
        public ?string $periodStartDate,
        public array $raw = []
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
            $payload['PeriodStartDate'] ?? null,
            $payload
        );
    }
}
