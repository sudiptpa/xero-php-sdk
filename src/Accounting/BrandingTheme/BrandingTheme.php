<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BrandingTheme;

final readonly class BrandingTheme
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $sortOrder,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['BrandingThemeID'] ?? null,
            $payload['Name'] ?? null,
            isset($payload['SortOrder']) ? (string) $payload['SortOrder'] : null,
            $payload
        );
    }
}
