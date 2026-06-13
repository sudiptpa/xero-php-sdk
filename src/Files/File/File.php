<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class File extends Model
{
    private ?string $id = null;

    private ?string $name = null;

    private ?string $mimeType = null;

    private int|string|null $size = null;

    private ?string $folderId = null;

    private ?string $createdDateUtc = null;

    private ?string $updatedDateUtc = null;

    private ?User $user = null;

    public function __construct(
        private ?Client $client = null
    ) {
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Id' => Field::string(),
            'Name' => Field::string(),
            'MimeType' => Field::string(),
            'Size' => Field::number(),
            'CreatedDateUtc' => Field::string()->using('setCreatedDateUTC'),
            'UpdatedDateUtc' => Field::string()->using('setUpdatedDateUTC'),
            'FolderId' => Field::string(),
            'User' => Field::object(User::class)->using('setUser'),
        ];
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
