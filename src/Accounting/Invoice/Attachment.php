<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Invoice;

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

}
