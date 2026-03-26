<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use RuntimeException;
use Sujip\Xero\Client;

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
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['PayRunID'] ?? null,
            $payload['PayrollCalendarID'] ?? null,
            $payload['PayRunStatus'] ?? $payload['Status'] ?? null,
            $payload['PaymentDate'] ?? null,
            $payload,
            $client
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a pay run without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->payrollCalendarId !== null) {
            $payload = $payload->payrollCalendar($this->payrollCalendarId);
        }

        return $payload->save();
    }
}
