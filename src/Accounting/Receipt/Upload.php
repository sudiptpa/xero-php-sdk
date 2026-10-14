<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Client;
use Sujip\Xero\Http\PendingRequest;
use Sujip\Xero\Support\Json;

final class Upload
{
    private ?string $mimeType = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $receiptId,
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

    public function save(): Attachment
    {
        return $this->send($this->client->put($this->path()));
    }

    public function update(): Attachment
    {
        return $this->send($this->client->post($this->path()));
    }

    private function path(): string
    {
        return '/api.xro/2.0/Receipts/' . $this->receiptId . '/Attachments/' . rawurlencode($this->fileName);
    }

    private function send(PendingRequest $request): Attachment
    {
        $response = $request
            ->withHeaders($this->mimeType === null ? [] : ['Content-Type' => $this->mimeType])
            ->withBody($this->content)
            ->send();

        $payload = $response->json();
        $attachment = Json::extractFirst($payload, 'Attachments') ?? [];

        return new Attachment(
            is_string($attachment['AttachmentID'] ?? null) ? $attachment['AttachmentID'] : null,
            is_string($attachment['FileName'] ?? null) ? $attachment['FileName'] : null,
            is_string($attachment['Url'] ?? null) ? $attachment['Url'] : null,
            is_string($attachment['MimeType'] ?? null) ? $attachment['MimeType'] : null,
            is_int($attachment['ContentLength'] ?? null) ? $attachment['ContentLength'] : null,
            isset($attachment['IncludeOnline']) ? (bool) $attachment['IncludeOnline'] : null,
            $attachment
        );
    }
}
