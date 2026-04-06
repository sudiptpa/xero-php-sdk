<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class CashValidationResult extends Model
{
    public function __construct(
        private ?string $status = null,
        private ?float $balance = null,
        private ?string $currency = null
    ) {
    }

    public function getStatus(): ?string { return $this->status; }
    public function setStatus(?string $status): self { $this->status = $status; return $this; }
    public function getBalance(): ?float { return $this->balance; }
    public function setBalance(?float $balance): self { $this->balance = $balance; return $this; }
    public function getCurrency(): ?string { return $this->currency; }
    public function setCurrency(?string $currency): self { $this->currency = $currency; return $this; }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Status' => Field::string()->using('setStatus'),
            'Balance' => Field::number()->using('setBalance'),
            'Currency' => Field::string()->using('setCurrency'),
        ];
    }
}
