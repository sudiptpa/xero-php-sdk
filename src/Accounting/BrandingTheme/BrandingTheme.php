<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BrandingTheme;

final class BrandingTheme
{
    private ?string $brandingThemeID = null;

    private ?string $name = null;

    private ?string $sortOrder = null;

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
