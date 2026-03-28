<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final readonly class Attachments
{
    public function __construct(
        private Client $client,
        private string $purchaseOrderId
    ) {
    }

    /**
     * @return ResourceCollection<Attachment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/PurchaseOrders/' . $this->purchaseOrderId . '/Attachments')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $attachment): Attachment => new Attachment(
                $attachment['AttachmentID'] ?? null,
                $attachment['FileName'] ?? null,
                $attachment['MimeType'] ?? null,
                isset($attachment['IncludeOnline']) ? (bool) $attachment['IncludeOnline'] : null,
                $attachment
            ),
            $payload['Attachments'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function upload(string $fileName, string $content): Upload
    {
        return new Upload($this->client, $this->purchaseOrderId, $fileName, $content);
    }

    public function download(string $fileName, string $contentType = 'application/octet-stream'): string
    {
        return $this->client
            ->get('/api.xro/2.0/PurchaseOrders/' . $this->purchaseOrderId . '/Attachments/' . rawurlencode($fileName))
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
            ->get('/api.xro/2.0/PurchaseOrders/' . $this->purchaseOrderId . '/Attachments/' . $attachmentId)
            ->withHeaders([
                'Accept' => $contentType,
                'contentType' => $contentType,
            ])
            ->send()
            ->body;
    }
}
