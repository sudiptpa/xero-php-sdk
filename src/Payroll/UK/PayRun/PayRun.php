<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

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
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['PayRunID'] ?? null,
            $payload['PayrollCalendarID'] ?? null,
            $payload['PayRunStatus'] ?? $payload['Status'] ?? null,
            $payload['PaymentDate'] ?? null,
            $payload,
            null
        );
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArrayWithClient(array $payload, Client $client): self
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

    /**
     * @return \Sujip\Xero\Support\ResourceCollection<Payslip>
     */
    public function payslips(): \Sujip\Xero\Support\ResourceCollection
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot load payslips without a bound client context and pay run id.');
        }

        return (new PayRuns($this->client))->payslips($this->id)->get();
    }
}
