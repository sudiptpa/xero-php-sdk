<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Client;
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
        $response = $this->client
            ->put('/api.xro/2.0/Receipts/' . $this->receiptId . '/Attachments/' . rawurlencode($this->fileName))
            ->withHeaders($this->mimeType === null ? [] : ['Content-Type' => $this->mimeType])
            ->withBody($this->content)
            ->send();

        $payload = $response->json();
        $attachment = Json::extractFirst($payload, 'Attachments') ?? [];

        return new Attachment(
            is_string($attachment['AttachmentID'] ?? null) ? $attachment['AttachmentID'] : null,
            is_string($attachment['FileName'] ?? null) ? $attachment['FileName'] : null,
            is_string($attachment['MimeType'] ?? null) ? $attachment['MimeType'] : null,
            isset($attachment['IncludeOnline']) ? (bool) $attachment['IncludeOnline'] : null,
            $attachment
        );
    }
}
