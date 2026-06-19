<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class SalesTrackingCategory extends Model implements SerializesRequest
{
    private ?string $trackingCategoryName = null;

    private ?string $trackingOptionName = null;

    public function getTrackingCategoryName(): ?string
    {
        return $this->trackingCategoryName;
    }

    public function setTrackingCategoryName(?string $trackingCategoryName): self
    {
        $this->trackingCategoryName = $trackingCategoryName;

        return $this;
    }

    public function getTrackingOptionName(): ?string
    {
        return $this->trackingOptionName;
    }

    public function setTrackingOptionName(?string $trackingOptionName): self
    {
        $this->trackingOptionName = $trackingOptionName;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'TrackingCategoryName' => Field::string(),
            'TrackingOptionName' => Field::string(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'TrackingCategoryName' => $this->getTrackingCategoryName(),
            'TrackingOptionName' => $this->getTrackingOptionName(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
