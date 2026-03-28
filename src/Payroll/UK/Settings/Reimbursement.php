<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Settings;

final class Reimbursement
{
    /**
     */
    public function __construct(
        private ?string $reimbursementID = null,
        private ?string $name = null,
        private ?string $accountCode = null,
    ) {
    }

    public function getReimbursementID(): ?string { return $this->reimbursementID; }
    public function setReimbursementID(?string $reimbursementID): self { $this->reimbursementID = $reimbursementID; return $this; }
    public function getName(): ?string { return $this->name; }
    public function setName(?string $name): self { $this->name = $name; return $this; }
    public function getAccountCode(): ?string { return $this->accountCode; }
    public function setAccountCode(?string $accountCode): self { $this->accountCode = $accountCode; return $this; }
    /**
     * @return array<string, mixed>
     */
    /**
     * @param array<string, mixed> $raw
     */
}
