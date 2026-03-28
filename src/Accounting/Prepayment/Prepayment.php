<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Prepayment;

final class Prepayment
{
    private ?string $prepaymentID = null;

    private ?string $type = null;

    private ?string $status = null;

    private int|float|null $remainingCredit = null;

    public function getPrepaymentID(): ?string
    {
        return $this->prepaymentID;
    }

    public function setPrepaymentID(?string $prepaymentID): self
    {
        $this->prepaymentID = $prepaymentID;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    public function getRemainingCredit(): int|float|null
    {
        return $this->remainingCredit;
    }

    public function setRemainingCredit(int|float|null $remainingCredit): self
    {
        $this->remainingCredit = $remainingCredit;

        return $this;
    }
}
