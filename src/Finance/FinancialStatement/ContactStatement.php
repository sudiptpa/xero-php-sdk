<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

final readonly class ContactStatement
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $contactId,
        public ?string $name,
        public ?float $total,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['ContactID']) ? (string) $payload['ContactID'] : null,
            isset($payload['Name']) ? (string) $payload['Name'] : null,
            isset($payload['Total']) ? (float) $payload['Total'] : null,
            $payload
        );
    }
}
