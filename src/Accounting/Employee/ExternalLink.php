<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Employee;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ExternalLink extends Model
{
    public function __construct(
        private ?string $linkType = null,
        private ?string $url = null,
        private ?string $description = null,
    ) {
    }

    public function getLinkType(): ?string
    {
        return $this->linkType;
    }

    public function setLinkType(?string $linkType): self
    {
        $this->linkType = $linkType;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'LinkType' => Field::string(),
            'Url' => Field::string(),
            'Description' => Field::string(),
        ];
    }
}
