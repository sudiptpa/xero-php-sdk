<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

final readonly class Attachment
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $fileName,
        public ?string $url,
        public ?string $mimeType,
        public ?int $contentLength,
        public ?bool $includeOnline,
        public array $raw = []
    ) {
    }

}
