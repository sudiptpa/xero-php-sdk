<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use RuntimeException;
use Sujip\Xero\Client;

final class Payload
{
    private const BASE_PATH = '/files.xro/1.0/Files';

    private ?string $id = null;

    private ?string $name = null;

    private ?string $folderId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $id): self
    {
        $clone = clone $this;
        $clone->id = $id;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->name = $name;

        return $clone;
    }

    public function folder(string $folderId): self
    {
        $clone = clone $this;
        $clone->folderId = $folderId;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): File
    {
        if ($this->id === null) {
            throw new RuntimeException('Cannot update a file without a file id.');
        }

        $response = $this->client
            ->put(self::BASE_PATH . '/' . $this->id)
            ->withHeaders($this->headers())
            ->withJson([
                'Name' => $this->name,
                'FolderId' => $this->folderId,
            ])
            ->send();

        return (new Files($this->client))->mapFile($response->json());
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        if ($this->idempotencyKey === null) {
            return [];
        }

        return ['Idempotency-Key' => $this->idempotencyKey];
    }
}
