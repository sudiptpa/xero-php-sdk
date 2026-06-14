<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TrackingCategory;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class TrackingCategory extends Model implements SerializesRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $trackingCategoryID = null;

    private ?string $trackingOptionID = null;

    private ?string $name = null;

    private ?string $option = null;

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
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'TrackingCategoryID' => Field::string(),
            'TrackingOptionID' => Field::string(),
            'Name' => Field::string(),
            'Option' => Field::string(),
            'Status' => Field::string(),
            'Options' => Field::many(Option::class),
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
