<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Account;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Account implements SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $accountID = null;

    private ?string $code = null;

    private ?string $name = null;

    private ?string $type = null;

    private ?string $status = null;

    private ?string $description = null;

    public function getAccountID(): ?string
    {
        return $this->accountID;
    }

    public function setAccountID(?string $accountID): self
    {
        $this->accountID = $accountID;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'AccountID' => $this->getAccountID(),
            'Code' => $this->getCode(),
            'Name' => $this->getName(),
            'Type' => $this->getType(),
            'Status' => $this->getStatus(),
            'Description' => $this->getDescription(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function code(string $code): self
    {
        return $this->setCode($code);
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function type(string $type): self
    {
        return $this->setType($type);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an account without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
