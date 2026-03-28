<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TaxRate;

use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Component implements SerializesForRequest
{
    private ?string $name = null;

    private int|float|null $rate = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRate(): int|float|null
    {
        return $this->rate;
    }

    public function setRate(int|float|null $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Name' => $this->getName(),
            'Rate' => $this->getRate(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
