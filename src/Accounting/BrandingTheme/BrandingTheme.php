<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BrandingTheme;

use Sujip\Xero\Support\Contracts\BuildsFromPayload;

final class BrandingTheme implements BuildsFromPayload
{
    private ?string $brandingThemeID = null;

    private ?string $name = null;

    private ?string $sortOrder = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?\Sujip\Xero\Client $client = null): static
    {
        return (new self())
            ->setBrandingThemeID($payload['BrandingThemeID'] ?? null)
            ->setName($payload['Name'] ?? null)
            ->setSortOrder(isset($payload['SortOrder']) ? (string) $payload['SortOrder'] : null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return self::fromPayload($payload);
    }

    public function getBrandingThemeID(): ?string
    {
        return $this->brandingThemeID;
    }

    public function setBrandingThemeID(?string $brandingThemeID): self
    {
        $this->brandingThemeID = $brandingThemeID;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSortOrder(): ?string
    {
        return $this->sortOrder;
    }

    public function setSortOrder(?string $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }
}
