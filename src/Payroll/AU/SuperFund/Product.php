<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

final readonly class Product
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $usi,
        public ?string $abn,
        public array $raw = [],
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['SuperFundProductID'] ?? null,
            $payload['Name'] ?? null,
            $payload['USI'] ?? null,
            $payload['ABN'] ?? null,
            $payload,
        );
    }
}
