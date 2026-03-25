<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

final readonly class Attachment
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $fileName,
        public ?string $mimeType,
        public ?bool $includeOnline,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['AttachmentID'] ?? null,
            $payload['FileName'] ?? null,
            $payload['MimeType'] ?? null,
            isset($payload['IncludeOnline']) ? (bool) $payload['IncludeOnline'] : null,
            $payload
        );
    }
}
