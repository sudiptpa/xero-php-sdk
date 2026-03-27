<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransaction;

use RuntimeException;
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class BankTransaction implements BuildsFromPayload, SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $bankTransactionID = null;

    private ?string $type = null;

    private ?string $status = null;

    private ?string $reference = null;

    private int|float|null $total = null;

    private ?Contact $contact = null;

    private ?BankAccount $bankAccount = null;

    /**
     * @var list<LineItem>
     */
    private array $lineItems = [];

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?Client $client = null): static
    {
        $transaction = (new self($client))
            ->setBankTransactionID($payload['BankTransactionID'] ?? null)
            ->setType($payload['Type'] ?? null)
            ->setStatus($payload['Status'] ?? null)
            ->setReference($payload['Reference'] ?? null)
            ->setTotal($payload['Total'] ?? null);

        $contact = $payload['Contact'] ?? null;
        if (is_array($contact)) {
            $transaction->setContact(Contact::fromPayload($contact));
        }

        $bankAccount = $payload['BankAccount'] ?? null;
        if (is_array($bankAccount)) {
            $transaction->setBankAccount(BankAccount::fromPayload($bankAccount));
        }

        foreach ($payload['LineItems'] ?? [] as $lineItem) {
            if (is_array($lineItem)) {
                $transaction->addLineItem(LineItem::fromPayload($lineItem));
            }
        }

        return $transaction;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

    public function getBankTransactionID(): ?string
    {
        return $this->bankTransactionID;
    }

    public function setBankTransactionID(?string $bankTransactionID): self
    {
        $this->bankTransactionID = $bankTransactionID;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type === null ? null : strtoupper($type);

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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

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

    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(?BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;

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
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'BankTransactionID' => $this->getBankTransactionID(),
            'Type' => $this->getType(),
            'Status' => $this->getStatus(),
            'Reference' => $this->getReference(),
            'Total' => $this->getTotal(),
            'Contact' => $this->getContact()?->toRequest(),
            'BankAccount' => $this->getBankAccount()?->toRequest(),
            'LineItems' => array_map(
                static fn (LineItem $lineItem): array => $lineItem->toRequest(),
                $this->getLineItems()
            ),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function reference(string $reference): self
    {
        return $this->setReference($reference);
    }

    public function type(string $type): self
    {
        return $this->setType($type);
    }

    public function contact(string $contactId): self
    {
        return $this->setContact(
            (new Contact())
                ->setContactID($contactId)
        );
    }

    public function bankAccount(string $accountId): self
    {
        return $this->setBankAccount(
            (new BankAccount())
                ->setAccountID($accountId)
        );
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        return $this->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a bank transaction without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function history(): History
    {
        if ($this->client === null || $this->bankTransactionID === null) {
            throw new RuntimeException('Cannot access bank transaction history without a bound client context and bank transaction id.');
        }

        return (new BankTransactions($this->client))->history($this->bankTransactionID);
    }
}
