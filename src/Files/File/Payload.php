<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

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
        $path = $this->id === null ? self::BASE_PATH : self::BASE_PATH . '/' . $this->id;
        $request = $this->id === null
            ? $this->client->post($path)
            : $this->client->put($path);

        $response = $request
            ->withHeaders($this->headers())
            ->withJson([
                'Name' => $this->name,
                'FolderId' => $this->folderId,
            ])
            ->send();

        $payload = $response->json();
        $file = Json::extractFirst($payload, 'Items') ?? [];

        if ($file === []) {
            return new File($this->client);
        }

        return (new Files($this->client))->mapFile($file);
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
