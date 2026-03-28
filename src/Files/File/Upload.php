<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Client;

final class Upload
{
    private const BASE_PATH = '/files.xro/1.0/Files';

    private ?string $mimeType = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $name,
        private readonly string $content,
        private readonly ?string $filename = null,
        private readonly ?string $folderId = null
    ) {
    }

    public function mimeType(string $mimeType): self
    {
        $clone = clone $this;
        $clone->mimeType = $mimeType;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function toFolder(string $folderId): self
    {
        $clone = new self($this->client, $this->name, $this->content, $this->filename, $folderId);
        $clone->mimeType = $this->mimeType;
        $clone->idempotencyKey = $this->idempotencyKey;

        return $clone;
    }

    public function save(): File
    {
        $path = $this->folderId === null
            ? self::BASE_PATH
            : self::BASE_PATH . '/' . $this->folderId;

        $response = $this->client
            ->post($path)
            ->withHeaders($this->headers())
            ->withQuery(array_filter([
                'name' => $this->name,
                'filename' => $this->filename ?? $this->name,
                'mimeType' => $this->mimeType,
            ], static fn (?string $value): bool => $value !== null && $value !== ''))
            ->withBody($this->content)
            ->send();

        $payload = $response->json();
        $file = $payload['Items'][0] ?? [];

        if (! is_array($file)) {
            return new File($this->client);
        }

        return (new Files($this->client))->mapFile($file);
    }

    /**
     * @return array<string, string>
     */
    private function headers(): array
    {
        $headers = [];

        if ($this->mimeType !== null) {
            $headers['Content-Type'] = $this->mimeType;
        }

        if ($this->idempotencyKey !== null) {
            $headers['Idempotency-Key'] = $this->idempotencyKey;
        }

        return $headers;
    }
}
