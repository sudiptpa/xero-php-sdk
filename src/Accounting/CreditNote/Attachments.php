<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;

final readonly class Attachments
{
    public function __construct(
        private Client $client,
        private string $creditNoteId
    ) {
    }

    /**
     * @return ResourceCollection<Attachment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/CreditNotes/' . $this->creditNoteId . '/Attachments')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $attachment): Attachment => Attachment::fromArray($attachment),
            $payload['Attachments'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function upload(string $fileName, string $content): Upload
    {
        return new Upload($this->client, $this->creditNoteId, $fileName, $content);
    }

    public function download(string $fileName, string $contentType = 'application/octet-stream'): string
    {
        return $this->client
            ->get('/api.xro/2.0/CreditNotes/' . $this->creditNoteId . '/Attachments/' . rawurlencode($fileName))
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
            ->get('/api.xro/2.0/CreditNotes/' . $this->creditNoteId . '/Attachments/' . $attachmentId)
            ->withHeaders([
                'Accept' => $contentType,
                'contentType' => $contentType,
            ])
            ->send()
            ->body;
    }
}
