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

        $boundary = bin2hex(random_bytes(16));

        $response = $this->client
            ->post($path)
            ->withHeaders($this->headers($boundary))
            ->withBody($this->multipartBody($boundary))
            ->send();

        return (new Files($this->client))->mapFile($response->json());
    }

    private function multipartBody(string $boundary): string
    {
        $filename = $this->filename ?? $this->name;

        $body = "--{$boundary}\r\n";
        $body .= "Content-Disposition: form-data; name=\"{$filename}\"; filename=\"{$filename}\"\r\n";

        if ($this->mimeType !== null) {
            $body .= "Content-Type: {$this->mimeType}\r\n";
        }

        $body .= "\r\n{$this->content}\r\n";
        $body .= "--{$boundary}--\r\n";

        return $body;
    }

    /**
     * @return array<string, string>
     */
    private function headers(string $boundary): array
    {
        $headers = [
            'Content-Type' => "multipart/form-data; boundary={$boundary}",
        ];

        if ($this->idempotencyKey !== null) {
            $headers['Idempotency-Key'] = $this->idempotencyKey;
        }

        return $headers;
    }
}
