<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class TaxRate implements SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $name = null;

    private ?string $taxType = null;

    private ?string $status = null;

    /**
     * @var list<Component>
     */
    private array $taxComponents = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTaxType(): ?string
    {
        return $this->taxType;
    }

    public function setTaxType(?string $taxType): self
    {
        $this->taxType = $taxType;

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
     * @return list<Component>
     */
    public function getTaxComponents(): array
    {
        return $this->taxComponents;
    }

    /**
     * @param list<Component> $taxComponents
     */
    public function setTaxComponents(array $taxComponents): self
    {
        $this->taxComponents = $taxComponents;

        return $this;
    }

    public function addTaxComponent(Component $component): self
    {
        $this->taxComponents[] = $component;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Name' => $this->getName(),
            'TaxType' => $this->getTaxType(),
            'Status' => $this->getStatus(),
            'TaxComponents' => array_map(
                static fn (Component $component): array => $component->toRequest(),
                $this->getTaxComponents()
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function component(string $name, int|float $rate): self
    {
        return $this->addTaxComponent(
            (new Component())
                ->setName($name)
                ->setRate($rate)
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a tax rate without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
