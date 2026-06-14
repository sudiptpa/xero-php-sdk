<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class LineItemTracking extends Model implements SerializesRequest
{
    private ?string $trackingCategoryID = null;

    private ?string $trackingOptionID = null;

    private ?string $name = null;

    private ?string $option = null;

    public function getTrackingCategoryID(): ?string
    {
        return $this->trackingCategoryID;
    }

    public function setTrackingCategoryID(?string $trackingCategoryID): self
    {
        $this->trackingCategoryID = $trackingCategoryID;

        return $this;
    }

    public function getTrackingOptionID(): ?string
    {
        return $this->trackingOptionID;
    }

    public function setTrackingOptionID(?string $trackingOptionID): self
    {
        $this->trackingOptionID = $trackingOptionID;

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

    public function getOption(): ?string
    {
        return $this->option;
    }

    public function setOption(?string $option): self
    {
        $this->option = $option;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'TrackingCategoryID' => Field::string(),
            'TrackingOptionID' => Field::string(),
            'Name' => Field::string(),
            'Option' => Field::string(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'TrackingCategoryID' => $this->getTrackingCategoryID(),
            'TrackingOptionID' => $this->getTrackingOptionID(),
            'Name' => $this->getName(),
            'Option' => $this->getOption(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
