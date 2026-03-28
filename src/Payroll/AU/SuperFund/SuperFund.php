<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\SuperFund;

final class SuperFund
{
    /**
     */
    public function __construct(
        private ?string $superFundID = null,
        private ?string $name = null,
        private ?string $type = null,
    ) {
    }

    public function getSuperFundID(): ?string { return $this->superFundID; }
    public function setSuperFundID(?string $superFundID): self { $this->superFundID = $superFundID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }
    public function getType(): ?string { return $this->type; }
    public function setType(?string $type): self { $this->type = $type; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
