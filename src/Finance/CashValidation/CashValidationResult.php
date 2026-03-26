<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

final readonly class CashValidationResult
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $status,
        public ?float $balance,
        public ?string $currency,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['Status']) ? (string) $payload['Status'] : null,
            isset($payload['Balance']) ? (float) $payload['Balance'] : null,
            isset($payload['Currency']) ? (string) $payload['Currency'] : null,
            $payload
        );
    }
}
