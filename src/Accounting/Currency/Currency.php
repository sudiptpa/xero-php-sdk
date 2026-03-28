<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Currency;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Currency implements SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $code = null;

    private ?string $description = null;

    private ?string $status = null;

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code === null ? null : strtoupper($code);

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequest(): array
    {
        return array_filter([
            'Code' => $this->getCode(),
            'Description' => $this->getDescription(),
            'Status' => $this->getStatus(),
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function description(string $description): self
    {
        return $this->setDescription($description);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a currency without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }
}
