<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

final readonly class Organisation
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $name,
        public ?string $legalName,
        public ?string $shortCode,
        public ?string $countryCode,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['Name'] ?? null,
            $payload['LegalName'] ?? null,
            $payload['ShortCode'] ?? null,
            $payload['CountryCode'] ?? null,
            $payload
        );
    }
}
