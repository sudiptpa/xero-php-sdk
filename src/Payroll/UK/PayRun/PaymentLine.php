<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class PaymentLine extends Model
{
    private ?string $paymentLineID = null;

    private ?float $amount = null;

    private ?string $accountNumber = null;

    private ?string $sortCode = null;

    private ?string $accountName = null;

    public function getPaymentLineID(): ?string
    {
        return $this->paymentLineID;
    }

    public function setPaymentLineID(?string $paymentLineID): self
    {
        $this->paymentLineID = $paymentLineID;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function setAccountNumber(?string $accountNumber): self
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    public function getSortCode(): ?string
    {
        return $this->sortCode;
    }

    public function setSortCode(?string $sortCode): self
    {
        $this->sortCode = $sortCode;

        return $this;
    }

    public function getAccountName(): ?string
    {
        return $this->accountName;
    }

    public function setAccountName(?string $accountName): self
    {
        $this->accountName = $accountName;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'paymentLineID' => Field::string(),
            'amount' => Field::number(),
            'accountNumber' => Field::string(),
            'sortCode' => Field::string(),
            'accountName' => Field::string(),
        ];
    }
}
