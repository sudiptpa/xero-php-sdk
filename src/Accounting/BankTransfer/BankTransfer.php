<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransfer;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class BankTransfer extends Model
{
    private ?string $bankTransferID = null;

    private ?string $fromBankAccountID = null;

    private ?string $toBankAccountID = null;

    private int|float|null $amount = null;

    private ?string $reference = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getBankTransferID(): ?string
    {
        return $this->bankTransferID;
    }

    public function setBankTransferID(?string $bankTransferID): self
    {
        $this->bankTransferID = $bankTransferID;

        return $this;
    }

    public function getFromBankAccountID(): ?string
    {
        return $this->fromBankAccountID;
    }

    public function setFromBankAccountID(?string $fromBankAccountID): self
    {
        $this->fromBankAccountID = $fromBankAccountID;

        return $this;
    }

    public function getToBankAccountID(): ?string
    {
        return $this->toBankAccountID;
    }

    public function setToBankAccountID(?string $toBankAccountID): self
    {
        $this->toBankAccountID = $toBankAccountID;

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'BankTransferID' => Field::string(),
            'Amount' => Field::number(),
            'Reference' => Field::string(),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        $fromBankAccount = is_array($payload['FromBankAccount'] ?? null) ? $payload['FromBankAccount'] : [];
        $this->setFromBankAccountID(
            isset($fromBankAccount['AccountID']) && is_string($fromBankAccount['AccountID'])
                ? $fromBankAccount['AccountID']
                : null
        );
        $toBankAccount = is_array($payload['ToBankAccount'] ?? null) ? $payload['ToBankAccount'] : [];
        $this->setToBankAccountID(
            isset($toBankAccount['AccountID']) && is_string($toBankAccount['AccountID'])
                ? $toBankAccount['AccountID']
                : null
        );

        return $this;
    }

    public function amount(int|float $amount): self
    {
        return $this->setAmount($amount);
    }

    public function reference(string $reference): self
    {
        return $this->setReference($reference);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a bank transfer without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->fromBankAccountID !== null) {
            $payload = $payload->fromBankAccount($this->fromBankAccountID);
        }

        if ($this->toBankAccountID !== null) {
            $payload = $payload->toBankAccount($this->toBankAccountID);
        }

        if ($this->amount !== null) {
            $payload = $payload->amount($this->amount);
        }

        if ($this->reference !== null) {
            $payload = $payload->reference($this->reference);
        }

        return $payload->save();
    }
}
