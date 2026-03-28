<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting;

final readonly class HistoryRecord
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $details,
        public ?string $dateUtc,
        public ?string $user,
        public array $raw = []
    ) {
    }

}
