<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Upload
{
    private ?string $mimeType = null;

    private bool $includeOnline = false;

    public function __construct(
        private readonly Client $client,
        private readonly string $purchaseOrderId,
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
        $path = '/api.xro/2.0/PurchaseOrders/' . $this->purchaseOrderId . '/Attachments/' . rawurlencode($this->fileName);

        if ($this->includeOnline) {
            $path .= '?IncludeOnline=true';
        }

        $response = $this->client
            ->put($path)
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
