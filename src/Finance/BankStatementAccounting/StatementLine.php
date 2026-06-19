<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\BankStatementAccounting;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class StatementLine extends Model
{
    private ?string $statementLineId = null;

    private ?string $postedDate = null;

    private ?string $payee = null;

    private ?string $reference = null;

    private ?string $notes = null;

    private ?string $chequeNo = null;

    private int|float|null $amount = null;

    private ?string $transactionDate = null;

    private ?string $type = null;

    private ?bool $isReconciled = null;

    private ?bool $isDuplicate = null;

    private ?bool $isDeleted = null;

    /**
     * @var list<Payment>
     */
    private array $payments = [];

    /**
     * @var list<BankTransaction>
     */
    private array $bankTransactions = [];

    public function getStatementLineId(): ?string
    {
        return $this->statementLineId;
    }

    public function setStatementLineId(?string $statementLineId): self
    {
        $this->statementLineId = $statementLineId;

        return $this;
    }

    public function getPostedDate(): ?string
    {
        return $this->postedDate;
    }

    public function setPostedDate(?string $postedDate): self
    {
        $this->postedDate = $postedDate;

        return $this;
    }

    public function getPayee(): ?string
    {
        return $this->payee;
    }

    public function setPayee(?string $payee): self
    {
        $this->payee = $payee;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function getChequeNo(): ?string
    {
        return $this->chequeNo;
    }

    public function setChequeNo(?string $chequeNo): self
    {
        $this->chequeNo = $chequeNo;

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

    public function getTransactionDate(): ?string
    {
        return $this->transactionDate;
    }

    public function setTransactionDate(?string $transactionDate): self
    {
        $this->transactionDate = $transactionDate;

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

    public function getIsReconciled(): ?bool
    {
        return $this->isReconciled;
    }

    public function setIsReconciled(?bool $isReconciled): self
    {
        $this->isReconciled = $isReconciled;

        return $this;
    }

    public function getIsDuplicate(): ?bool
    {
        return $this->isDuplicate;
    }

    public function setIsDuplicate(?bool $isDuplicate): self
    {
        $this->isDuplicate = $isDuplicate;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * @return list<Payment>
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    /**
     * @param list<Payment> $payments
     */
    public function setPayments(array $payments): self
    {
        $this->payments = $payments;

        return $this;
    }

    public function addPayment(Payment $payment): self
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * @return list<BankTransaction>
     */
    public function getBankTransactions(): array
    {
        return $this->bankTransactions;
    }

    /**
     * @param list<BankTransaction> $bankTransactions
     */
    public function setBankTransactions(array $bankTransactions): self
    {
        $this->bankTransactions = $bankTransactions;

        return $this;
    }

    public function addBankTransaction(BankTransaction $bankTransaction): self
    {
        $this->bankTransactions[] = $bankTransaction;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'statementLineId' => Field::string(),
            'postedDate' => Field::string(),
            'payee' => Field::string(),
            'reference' => Field::string(),
            'notes' => Field::string(),
            'chequeNo' => Field::string(),
            'amount' => Field::number(),
            'transactionDate' => Field::string(),
            'type' => Field::string(),
            'isReconciled' => Field::boolean(),
            'isDuplicate' => Field::boolean(),
            'isDeleted' => Field::boolean(),
            'payments' => Field::many(Payment::class),
            'bankTransactions' => Field::many(BankTransaction::class),
        ];
    }
}
