<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

final readonly class Statement
{
    /**
     * @param list<array<string, mixed>> $rows
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public string $type,
        public array $rows = [],
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(string $type, array $payload): self
    {
        return new self(
            $type,
            array_values($payload['Rows'] ?? $payload['rows'] ?? []),
            $payload
        );
    }
}
