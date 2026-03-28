<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TrackingCategory;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class TrackingCategory implements SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $trackingCategoryID = null;

    private ?string $name = null;

    private ?string $status = null;

    /**
     * @var list<Option>
     */
    private array $options = [];

    public function getTrackingCategoryID(): ?string
    {
        return $this->trackingCategoryID;
    }

    public function setTrackingCategoryID(?string $trackingCategoryID): self
    {
        $this->trackingCategoryID = $trackingCategoryID;

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
     * @return list<Option>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param list<Option> $options
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function addOption(Option $option): self
    {
        $this->options[] = $option;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'TrackingCategoryID' => $this->getTrackingCategoryID(),
            'Name' => $this->getName(),
            'Status' => $this->getStatus(),
            'Options' => array_map(
                static fn (Option $option): array => $option->toRequest(),
                $this->getOptions()
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function option(string $name): self
    {
        return $this->addOption(
            (new Option())
                ->setName($name)
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a tracking category without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
