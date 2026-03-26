<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class File
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public ?string $mimeType,
        public int|string|null $size = null,
        public ?string $folderId = null,
        public ?string $createdDateUtc = null,
        public ?string $updatedDateUtc = null,
        public ?string $user = null,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        $folder = $payload['FolderId'] ?? null;

        return new self(
            $payload['Id'] ?? null,
            $payload['Name'] ?? null,
            $payload['MimeType'] ?? null,
            $payload['Size'] ?? null,
            is_array($folder) ? ($folder['Id'] ?? null) : (is_string($folder) ? $folder : null),
            $payload['CreatedDateUTC'] ?? null,
            $payload['UpdatedDateUTC'] ?? null,
            $payload['User'] ?? null,
            $payload,
            $client
        );
    }

    public function rename(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self(
            $this->id,
            $name,
            $this->mimeType,
            $this->size,
            $this->folderId,
            $this->createdDateUtc,
            $this->updatedDateUtc,
            $this->user,
            $payload,
            $this->client
        );
    }

    public function moveToFolder(string $folderId): self
    {
        $payload = $this->raw;
        $payload['FolderId'] = $folderId;

        return new self(
            $this->id,
            $this->name,
            $this->mimeType,
            $this->size,
            $folderId,
            $this->createdDateUtc,
            $this->updatedDateUtc,
            $this->user,
            $payload,
            $this->client
        );
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
