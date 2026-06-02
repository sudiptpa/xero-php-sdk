<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;

final readonly class Attachments
{
    public function __construct(
        private Client $client,
        private string $receiptId
    ) {
    }

    /**
     * @return ResourceCollection<Attachment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Receipts/' . $this->receiptId . '/Attachments')
            ->send();

        $payload = $response->json();
        $items = array_map(
            static fn (array $attachment): Attachment => new Attachment(
                is_string($attachment['AttachmentID'] ?? null) ? $attachment['AttachmentID'] : null,
                is_string($attachment['FileName'] ?? null) ? $attachment['FileName'] : null,
                is_string($attachment['MimeType'] ?? null) ? $attachment['MimeType'] : null,
                isset($attachment['IncludeOnline']) ? (bool) $attachment['IncludeOnline'] : null,
                $attachment
            ),
            Json::extractList($payload, 'Attachments')
        );

        return new ResourceCollection($items);
    }

    public function upload(string $fileName, string $content): Upload
    {
        return new Upload($this->client, $this->receiptId, $fileName, $content);
    }

    public function download(string $fileName, string $contentType = 'application/octet-stream'): string
    {
        return $this->client
            ->get('/api.xro/2.0/Receipts/' . $this->receiptId . '/Attachments/' . rawurlencode($fileName))
            ->withHeaders([
                'Accept' => $contentType,
                'contentType' => $contentType,
            ])
            ->send()
            ->body;
    }

    public function downloadById(string $attachmentId, string $contentType = 'application/octet-stream'): string
    {
        return $this->client
            ->get('/api.xro/2.0/Receipts/' . $this->receiptId . '/Attachments/' . $attachmentId)
            ->withHeaders([
                'Accept' => $contentType,
                'contentType' => $contentType,
            ])
            ->send()
            ->body;
    }
}
