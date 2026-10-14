<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\CreditNote;

final readonly class HistoryRecord
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $details,
        public ?string $user,
        public ?string $changes,
        public ?string $dateUtc = null,
        public array $raw = []
    ) {
    }

}
