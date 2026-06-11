<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Client;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;

final readonly class Attachments
{
    public function __construct(
        private Client $client,
        private string $manualJournalId
    ) {
    }

    /**
     * @return ResourceCollection<Attachment>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get('/api.xro/2.0/ManualJournals/' . $this->manualJournalId . '/Attachments')
            ->send()
            ->json();

        $items = array_map(
            static fn (array $attachment): Attachment => new Attachment(
                is_string($attachment['FileName'] ?? null) ? $attachment['FileName'] : null,
                is_string($attachment['Url'] ?? null) ? $attachment['Url'] : null,
                $attachment
            ),
            Json::extractList($payload, 'Attachments')
        );

        return new ResourceCollection($items);
    }

    public function upload(string $fileName, string $content): Upload
    {
        return new Upload($this->client, $this->manualJournalId, $fileName, $content);
    }

    public function download(string $fileName, string $contentType = 'application/octet-stream'): string
    {
        return $this->client
            ->get('/api.xro/2.0/ManualJournals/' . $this->manualJournalId . '/Attachments/' . rawurlencode($fileName))
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
            ->get('/api.xro/2.0/ManualJournals/' . $this->manualJournalId . '/Attachments/' . $attachmentId)
            ->withHeaders([
                'Accept' => $contentType,
                'contentType' => $contentType,
            ])
            ->send()
            ->body;
    }
}
