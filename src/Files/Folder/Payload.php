<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\Folder;

use Sujip\Xero\Client;

final class Payload
{
    private const BASE_PATH = '/files.xro/1.0/Folders';

    private ?string $id = null;

    private ?string $name = null;

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

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): Folder
    {
        $path = $this->id === null ? self::BASE_PATH : self::BASE_PATH . '/' . $this->id;
        $request = $this->id === null
            ? $this->client->post($path)
            : $this->client->put($path);

        $response = $request
            ->withHeaders($this->headers())
            ->withJson([
                'Name' => $this->name,
            ])
            ->send();

        $payload = $response->json();
        $folder = $payload['Items'][0] ?? [];

        return Folder::fromArray(is_array($folder) ? $folder : [], $this->client);
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
