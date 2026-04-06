<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

/**
 * @template TItem
 */
class PaginatedCollection
{
    /**
     * @param ResourceCollection<TItem> $items
     * @param array<string, mixed> $meta
     */
    public function __construct(
        public readonly ResourceCollection $items,
        public readonly ?int $page = null,
        public readonly ?int $perPage = null,
        public readonly array $meta = []
    ) {
    }
}
