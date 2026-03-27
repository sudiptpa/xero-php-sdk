<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Item;

use RuntimeException;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\BuildsFromPayload;
use Sujip\Xero\Support\Contracts\SerializesForRequest;

final class Item implements BuildsFromPayload, SerializesForRequest
{
    public function __construct(
        private ?Client $client = null
    ) {
    }

    private ?string $itemID = null;

    private ?string $code = null;

    private ?string $name = null;

    private ?string $description = null;

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?Client $client = null): static
    {
        return (new self($client))
            ->setItemID($payload['ItemID'] ?? null)
            ->setCode($payload['Code'] ?? null)
            ->setName($payload['Name'] ?? null)
            ->setDescription($payload['Description'] ?? null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

    public function getItemID(): ?string
    {
        return $this->itemID;
    }

    public function setItemID(?string $itemID): self
    {
        $this->itemID = $itemID;

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
            'ItemID' => $this->getItemID(),
            'Code' => $this->getCode(),
            'Name' => $this->getName(),
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

    public function description(string $description): self
    {
        return $this->setDescription($description);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an item without a bound client context.');
        }

        $payload = new Payload($this->client);

        return $payload->using($this)->save();
    }

    public function history(): History
    {
        if ($this->client === null || $this->itemID === null) {
            throw new RuntimeException('Cannot access item history without a bound client context and item id.');
        }

        return (new Items($this->client))->history($this->itemID);
    }
}
