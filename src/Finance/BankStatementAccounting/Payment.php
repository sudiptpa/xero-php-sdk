<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\BankStatementAccounting;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Payment extends Model
{
    private ?string $paymentId = null;

    private ?string $batchPaymentId = null;

    private ?string $date = null;

    private int|float|null $amount = null;

    private int|float|null $bankAmount = null;

    private int|float|null $currencyRate = null;

    private ?Invoice $invoice = null;

    private ?CreditNote $creditNote = null;

    private ?Prepayment $prepayment = null;

    private ?Overpayment $overpayment = null;

    public function getPaymentId(): ?string
    {
        return $this->paymentId;
    }

    public function setPaymentId(?string $paymentId): self
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    public function getBatchPaymentId(): ?string
    {
        return $this->batchPaymentId;
    }

    public function setBatchPaymentId(?string $batchPaymentId): self
    {
        $this->batchPaymentId = $batchPaymentId;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmount(): int|float|null
    {
        return $this->amount;
    }

    public function setAmount(int|float|null $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getBankAmount(): int|float|null
    {
        return $this->bankAmount;
    }

    public function setBankAmount(int|float|null $bankAmount): self
    {
        $this->bankAmount = $bankAmount;

        return $this;
    }

    public function getCurrencyRate(): int|float|null
    {
        return $this->currencyRate;
    }

    public function setCurrencyRate(int|float|null $currencyRate): self
    {
        $this->currencyRate = $currencyRate;

        return $this;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): self
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getCreditNote(): ?CreditNote
    {
        return $this->creditNote;
    }

    public function setCreditNote(?CreditNote $creditNote): self
    {
        $this->creditNote = $creditNote;

        return $this;
    }

    public function getPrepayment(): ?Prepayment
    {
        return $this->prepayment;
    }

    public function setPrepayment(?Prepayment $prepayment): self
    {
        $this->prepayment = $prepayment;

        return $this;
    }

    public function getOverpayment(): ?Overpayment
    {
        return $this->overpayment;
    }

    public function setOverpayment(?Overpayment $overpayment): self
    {
        $this->overpayment = $overpayment;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'paymentId' => Field::string(),
            'batchPaymentId' => Field::string(),
            'date' => Field::string(),
            'amount' => Field::number(),
            'bankAmount' => Field::number(),
            'currencyRate' => Field::number(),
            'invoice' => Field::object(Invoice::class),
            'creditNote' => Field::object(CreditNote::class),
            'prepayment' => Field::object(Prepayment::class),
            'overpayment' => Field::object(Overpayment::class),
        ];
    }
}
