<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Client;

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
        $attachment = $payload['Attachments'][0] ?? [];

        return Attachment::fromArray(is_array($attachment) ? $attachment : []);
    }
}
