<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransfer;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class BankTransfer
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $fromBankAccountId,
        public ?string $toBankAccountId,
        public int|float|null $amount,
        public ?string $reference = null,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['BankTransferID'] ?? null,
            $payload['FromBankAccount']['AccountID'] ?? null,
            $payload['ToBankAccount']['AccountID'] ?? null,
            $payload['Amount'] ?? null,
            $payload['Reference'] ?? null,
            $payload,
            $client
        );
    }

    public function amount(int|float $amount): self
    {
        $payload = $this->raw;
        $payload['Amount'] = $amount;

        return new self(
            $this->id,
            $this->fromBankAccountId,
            $this->toBankAccountId,
            $amount,
            $this->reference,
            $payload,
            $this->client
        );
    }

    public function reference(string $reference): self
    {
        $payload = $this->raw;
        $payload['Reference'] = $reference;

        return new self(
            $this->id,
            $this->fromBankAccountId,
            $this->toBankAccountId,
            $this->amount,
            $reference,
            $payload,
            $this->client
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a bank transfer without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->fromBankAccountId !== null) {
            $payload = $payload->fromBankAccount($this->fromBankAccountId);
        }

        if ($this->toBankAccountId !== null) {
            $payload = $payload->toBankAccount($this->toBankAccountId);
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
