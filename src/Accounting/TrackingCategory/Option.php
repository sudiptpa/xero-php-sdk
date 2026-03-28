<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TrackingCategory;

use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Option implements SerializesForRequest
{
    private ?string $trackingOptionID = null;

    private ?string $name = null;

    private ?string $status = null;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'TrackingOptionID' => $this->getTrackingOptionID(),
            'Name' => $this->getName(),
            'Status' => $this->getStatus(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
