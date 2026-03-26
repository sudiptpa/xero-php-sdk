<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

final readonly class PayRun
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $payrollCalendarId,
        public ?string $status,
        public ?string $paymentDate,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['PayRunID'] ?? null,
            $payload['PayrollCalendarID'] ?? null,
            $payload['PayRunStatus'] ?? $payload['Status'] ?? null,
            $payload['PaymentDate'] ?? null,
            $payload
        );
    }
}
