<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Organisation extends Model
{
    private ?string $name = null;

    private ?string $legalName = null;

    private ?string $shortCode = null;

    private ?string $countryCode = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLegalName(): ?string
    {
        return $this->legalName;
    }

    public function setLegalName(?string $legalName): self
    {
        $this->legalName = $legalName;

        return $this;
    }

    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    public function setShortCode(?string $shortCode): self
    {
        $this->shortCode = $shortCode;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): self
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Name' => Field::string(),
            'LegalName' => Field::string(),
            'ShortCode' => Field::string(),
            'CountryCode' => Field::string(),
        ];
    }
}
