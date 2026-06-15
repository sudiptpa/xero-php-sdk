<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Organisation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Contracts\SerializesRequest;

final class PaymentTerm extends Model implements SerializesRequest
{
    private ?Bill $bills = null;

    private ?Bill $sales = null;

    public function getBills(): ?Bill
    {
        return $this->bills;
    }

    public function setBills(?Bill $bills): self
    {
        $this->bills = $bills;

        return $this;
    }

    public function getSales(): ?Bill
    {
        return $this->sales;
    }

    public function setSales(?Bill $sales): self
    {
        $this->sales = $sales;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Bills' => Field::object(Bill::class),
            'Sales' => Field::object(Bill::class),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Bills' => $this->getBills()?->toRequest(),
            'Sales' => $this->getSales()?->toRequest(),
        ], static fn (mixed $value): bool => $value !== null);
    }
}
