<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final readonly class Upload
{
    public function __construct(
        private Client $client,
        private string $manualJournalId,
        private string $fileName,
        private string $content,
        private ?string $mimeType = null
    ) {
    }

    public function mimeType(string $mimeType): self
    {
        return new self($this->client, $this->manualJournalId, $this->fileName, $this->content, $mimeType);
    }

    public function save(): Attachment
    {
        $request = $this->client
            ->put('/api.xro/2.0/ManualJournals/' . $this->manualJournalId . '/Attachments/' . rawurlencode($this->fileName))
            ->withBody($this->content);

        if ($this->mimeType !== null) {
            $request = $request->withHeaders(['Content-Type' => $this->mimeType]);
        }

        $payload = $request->send()->json();
        $attachment = Json::extractFirst($payload, 'Attachments') ?? [];

        return new Attachment(
            is_string($attachment['FileName'] ?? null) ? $attachment['FileName'] : null,
            is_string($attachment['Url'] ?? null) ? $attachment['Url'] : null,
            $attachment
        );
    }
}
