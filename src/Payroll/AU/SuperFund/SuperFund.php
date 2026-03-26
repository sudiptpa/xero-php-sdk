<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

final readonly class SuperFund
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $type,
        public array $raw = [],
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['SuperFundID'] ?? null,
            $payload['Name'] ?? null,
            $payload['Type'] ?? null,
            $payload,
        );
    }
}
