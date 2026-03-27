<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ManualJournal;

final readonly class Attachment
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $fileName,
        public ?string $url,
        public array $raw = []
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            isset($payload['FileName']) ? (string) $payload['FileName'] : null,
            isset($payload['Url']) ? (string) $payload['Url'] : null,
            $payload
        );
    }
}
