<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

final class ContactStatement
{
    public function __construct(
        private ?string $contactID = null,
        private ?string $name = null,
        private ?float $total = null
    ) {
    }

    public function getContactID(): ?string { return $this->contactID; }
    public function setContactID(?string $contactID): self { $this->contactID = $contactID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }
    public function getTotal(): ?float { return $this->total; }
    public function setTotal(?float $total): self { $this->total = $total; return $this; }
}
