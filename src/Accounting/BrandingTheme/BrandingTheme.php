<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BrandingTheme;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BrandingTheme extends Model
{
    private ?string $brandingThemeID = null;

    private ?string $name = null;

    private ?int $sortOrder = null;

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

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(?int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'BrandingThemeID' => Field::string(),
            'Name' => Field::string(),
            'SortOrder' => Field::number(),
        ];
    }
}
