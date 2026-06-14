<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\BankStatementAccounting;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BankTransaction extends Model
{
    private ?string $bankTransactionId = null;

    private ?string $batchPaymentId = null;

    private ?Contact $contact = null;

    private ?string $date = null;

    private int|float|null $amount = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    public function getBankTransactionId(): ?string
    {
        return $this->bankTransactionId;
    }

    public function setBankTransactionId(?string $bankTransactionId): self
    {
        $this->bankTransactionId = $bankTransactionId;

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

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

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

    /**
     * @return list<LineItem>
     */
    public function getLineItems(): array
    {
        return $this->lineItems;
    }

    /**
     * @param list<LineItem> $lineItems
     */
    public function setLineItems(array $lineItems): self
    {
        $this->lineItems = $lineItems;

        return $this;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        $this->lineItems[] = $lineItem;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'bankTransactionId' => Field::string(),
            'batchPaymentId' => Field::string(),
            'contact' => Field::object(Contact::class),
            'date' => Field::string(),
            'amount' => Field::number(),
            'lineItems' => Field::many(LineItem::class),
        ];
    }
}
