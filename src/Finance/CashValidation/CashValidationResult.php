<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

final class CashValidationResult
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
}
