<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\Folder;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Files\File\Files as FilesResource;
use Sujip\Xero\Files\File\Upload;

final readonly class Folder
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $name,
        public int|string|null $fileCount = null,
        public ?string $email = null,
        public ?bool $isInbox = null,
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
            $payload['Id'] ?? null,
            $payload['Name'] ?? null,
            $payload['FileCount'] ?? null,
            $payload['Email'] ?? null,
            $payload['IsInbox'] ?? null,
            $payload,
            $client
        );
    }

    public function name(string $name): self
    {
        $payload = $this->raw;
        $payload['Name'] = $name;

        return new self(
            $this->id,
            $name,
            $this->fileCount,
            $this->email,
            $this->isInbox,
            $payload,
            $this->client
        );
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
