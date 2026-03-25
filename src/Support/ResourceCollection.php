<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

use Countable;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

/**
 * @template TItem
 * @implements IteratorAggregate<int, TItem>
 */
final class ResourceCollection implements Countable, IteratorAggregate
{
    /**
     * @param list<TItem> $items
     */
    public function __construct(
        private readonly array $items
    ) {
    }

    /**
     * @return list<TItem>
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * @return TItem|null
     */
    public function first(): mixed
    {
        return $this->items[0] ?? null;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
