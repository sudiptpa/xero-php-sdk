<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayItem;

final readonly class PayItem
{
    /**
     * @param list<array<string, mixed>> $earningsRates
     * @param list<array<string, mixed>> $deductionTypes
     * @param list<array<string, mixed>> $leaveTypes
     * @param list<array<string, mixed>> $reimbursementTypes
     * @param list<array<string, mixed>> $superannuationTypes
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public array $earningsRates = [],
        public array $deductionTypes = [],
        public array $leaveTypes = [],
        public array $reimbursementTypes = [],
        public array $superannuationTypes = [],
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            array_values($payload['EarningsRates'] ?? []),
            array_values($payload['DeductionTypes'] ?? []),
            array_values($payload['LeaveTypes'] ?? []),
            array_values($payload['ReimbursementTypes'] ?? []),
            array_values($payload['SuperannuationTypes'] ?? []),
            $payload
        );
    }
}
