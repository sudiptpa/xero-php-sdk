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

}
