<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Client;

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
        $attachment = $payload['Attachments'][0] ?? [];

        return Attachment::fromArray(is_array($attachment) ? $attachment : []);
    }
}
