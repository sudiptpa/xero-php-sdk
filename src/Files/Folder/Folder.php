<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\Folder;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Files\File\Files as FilesResource;
use Sujip\Xero\Files\File\Upload;
use Sujip\Xero\Support\Contracts\BuildsFromPayload;

final class Folder implements BuildsFromPayload
{
    private ?string $id = null;

    private ?string $name = null;

    private int|string|null $fileCount = null;

    private ?string $email = null;

    private ?bool $isInbox = null;

    /**
     * @var array<string, mixed>
     */
    private array $raw = [];

    public function __construct(
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromPayload(array $payload, ?Client $client = null): static
    {
        return (new self($client))
            ->setId($payload['Id'] ?? null)
            ->setName($payload['Name'] ?? null)
            ->setFileCount($payload['FileCount'] ?? null)
            ->setEmail($payload['Email'] ?? null)
            ->setIsInbox($payload['IsInbox'] ?? null)
            ->setRaw($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return self::fromPayload($payload, $client);
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): self
    {
        $this->id = $id;

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

    public function getFileCount(): int|string|null
    {
        return $this->fileCount;
    }

    public function setFileCount(int|string|null $fileCount): self
    {
        $this->fileCount = $fileCount;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIsInbox(): ?bool
    {
        return $this->isInbox;
    }

    public function setIsInbox(?bool $isInbox): self
    {
        $this->isInbox = $isInbox;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * @param array<string, mixed> $raw
     */
    public function setRaw(array $raw): self
    {
        $this->raw = $raw;

        return $this;
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a folder without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        return $payload->save();
    }

    public function files(): FilesResource
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access folder files without a bound client context and folder id.');
        }

        return (new FilesResource($this->client))->inFolder($this->id);
    }

    public function upload(string $name, string $content, ?string $filename = null): Upload
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot upload into a folder without a bound client context and folder id.');
        }

        return new Upload($this->client, $name, $content, $filename, $this->id);
    }

    public function delete(): bool
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot delete a folder without a bound client context and folder id.');
        }

        return (new Folders($this->client))->delete($this->id);
    }
}
