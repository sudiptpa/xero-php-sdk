<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final readonly class AccountingActivity
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $month,
        public ?float $totalIncome,
        public ?float $totalExpense,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['Month']) ? (string) $payload['Month'] : null,
            isset($payload['TotalIncome']) ? (float) $payload['TotalIncome'] : null,
            isset($payload['TotalExpense']) ? (float) $payload['TotalExpense'] : null,
            $payload
        );
    }
}
