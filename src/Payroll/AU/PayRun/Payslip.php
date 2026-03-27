<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

final readonly class Payslip
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $employeeId,
        public ?string $paymentDate,
        public ?string $netPay,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['PayslipID'] ?? null,
            $payload['EmployeeID'] ?? null,
            $payload['PaymentDate'] ?? null,
            isset($payload['NetPay']) ? (string) $payload['NetPay'] : null,
            $payload
        );
    }
}
