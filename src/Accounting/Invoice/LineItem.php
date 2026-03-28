<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class LineItem implements SerializesForRequest
{
    private ?string $description = null;

    private int|float|null $quantity = null;

    private int|float|null $unitAmount = null;

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): int|float|null
    {
        return $this->quantity;
    }

    public function setQuantity(int|float|null $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitAmount(): int|float|null
    {
        return $this->unitAmount;
    }

    public function setUnitAmount(int|float|null $unitAmount): self
    {
        $this->unitAmount = $unitAmount;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Description' => $this->getDescription(),
            'Quantity' => $this->getQuantity(),
            'UnitAmount' => $this->getUnitAmount(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
