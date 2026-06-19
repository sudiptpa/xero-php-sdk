<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ResourceCollection;

final readonly class Attachments
{
    public function __construct(
        private Client $client,
        private string $path
    ) {
    }

    /**
     * @return ResourceCollection<Attachment>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get($this->path)
            ->send()
            ->json();

        $items = array_map(
            static fn (array $attachment): Attachment => self::mapAttachment($attachment),
            Json::extractList($payload, 'Attachments')
        );

        return new ResourceCollection($items);
    }

    public function upload(string $fileName, string $content): AttachmentUpload
    {
        return new AttachmentUpload($this->client, $this->path, $fileName, $content);
    }

    public function download(string $fileName, string $contentType = 'application/octet-stream'): string
    {
        return $this->client
            ->get($this->path . '/' . rawurlencode($fileName))
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
            ->get($this->path . '/' . $attachmentId)
            ->withHeaders([
                'Accept' => $contentType,
                'contentType' => $contentType,
            ])
            ->send()
            ->body;
    }

    /**
     * @param array<string, mixed> $attachment
     */
    public static function mapAttachment(array $attachment): Attachment
    {
        return new Attachment(
            is_string($attachment['AttachmentID'] ?? null) ? $attachment['AttachmentID'] : null,
            is_string($attachment['FileName'] ?? null) ? $attachment['FileName'] : null,
            is_string($attachment['MimeType'] ?? null) ? $attachment['MimeType'] : null,
            isset($attachment['IncludeOnline']) ? (bool) $attachment['IncludeOnline'] : null,
            $attachment
        );
    }
}
