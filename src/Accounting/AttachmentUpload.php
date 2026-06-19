<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Http\PendingRequest;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class AttachmentUpload
{
    private ?string $mimeType = null;

    private bool $includeOnline = false;

    public function __construct(
        private readonly Client $client,
        private readonly string $path,
        private readonly string $fileName,
        private readonly string $content
    ) {
    }

    public function mimeType(string $mimeType): self
    {
        $clone = clone $this;
        $clone->mimeType = $mimeType;

        return $clone;
    }

    public function includeOnline(bool $includeOnline = true): self
    {
        $clone = clone $this;
        $clone->includeOnline = $includeOnline;

        return $clone;
    }

    public function save(): Attachment
    {
        return $this->send($this->client->put($this->uploadPath()));
    }

    public function update(): Attachment
    {
        return $this->send($this->client->post($this->uploadPath()));
    }

    private function uploadPath(): string
    {
        $path = $this->path . '/' . rawurlencode($this->fileName);

        if ($this->includeOnline) {
            $path .= '?IncludeOnline=true';
        }

        return $path;
    }

    private function send(PendingRequest $request): Attachment
    {
        $payload = $request
            ->withHeaders($this->mimeType === null ? [] : ['Content-Type' => $this->mimeType])
            ->withBody($this->content)
            ->send()
            ->json();

        $attachment = Json::extractFirst($payload, 'Attachments') ?? [];

        return Attachments::mapAttachment($attachment);
    }
}
