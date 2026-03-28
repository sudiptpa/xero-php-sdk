<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\BuildsFromPayload;

final class File implements BuildsFromPayload
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $mimeType = null;

    private int|string|null $size = null;

    private ?string $folderId = null;

    private ?string $createdDateUtc = null;

    private ?string $updatedDateUtc = null;

    private ?string $user = null;

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
        $folder = $payload['FolderId'] ?? null;

        return (new self($client))
            ->setId($payload['Id'] ?? null)
            ->setName($payload['Name'] ?? null)
            ->setMimeType($payload['MimeType'] ?? null)
            ->setSize($payload['Size'] ?? null)
            ->setFolderId(is_array($folder) ? ($folder['Id'] ?? null) : (is_string($folder) ? $folder : null))
            ->setCreatedDateUTC($payload['CreatedDateUTC'] ?? null)
            ->setUpdatedDateUTC($payload['UpdatedDateUTC'] ?? null)
            ->setUser(is_string($payload['User'] ?? null) ? $payload['User'] : null)
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

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getSize(): int|string|null
    {
        return $this->size;
    }

    public function setSize(int|string|null $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getFolderId(): ?string
    {
        return $this->folderId;
    }

    public function setFolderId(?string $folderId): self
    {
        $this->folderId = $folderId;

        return $this;
    }

    public function getCreatedDateUTC(): ?string
    {
        return $this->createdDateUtc;
    }

    public function setCreatedDateUTC(?string $createdDateUtc): self
    {
        $this->createdDateUtc = $createdDateUtc;

        return $this;
    }

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUtc;
    }

    public function setUpdatedDateUTC(?string $updatedDateUtc): self
    {
        $this->updatedDateUtc = $updatedDateUtc;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): self
    {
        $this->user = $user;

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

    public function rename(string $name): self
    {
        return $this->setName($name);
    }

    public function moveToFolder(string $folderId): self
    {
        return $this->setFolderId($folderId);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a file without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->name !== null) {
            $payload = $payload->name($this->name);
        }

        if ($this->folderId !== null) {
            $payload = $payload->folder($this->folderId);
        }

        return $payload->save();
    }

    public function content(): string
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot fetch file content without a bound client context and file id.');
        }

        return (new Files($this->client))->content($this->id);
    }

    public function associations(): Associations
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access file associations without a bound client context and file id.');
        }

        return new Associations($this->client, $this->id);
    }

    public function delete(): bool
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot delete a file without a bound client context and file id.');
        }

        return (new Files($this->client))->delete($this->id);
    }
}
