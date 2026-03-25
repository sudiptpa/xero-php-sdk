<?php

declare(strict_types=1);

namespace Sujip\Xero\Support\Concerns;

use DateTimeInterface;

trait BuildsQueries
{
    /**
     * @var array<string, scalar|array<int, scalar>|null>
     */
    private array $query = [];

    public function modifiedSince(DateTimeInterface $date): static
    {
        $clone = clone $this;
        $clone->query['If-Modified-Since'] = $date->format(DateTimeInterface::RFC7231);

        return $clone;
    }

    public function orderBy(string $field, string $direction = 'ASC'): static
    {
        $clone = clone $this;
        $clone->query['order'] = $field . ' ' . strtoupper($direction);

        return $clone;
    }

    public function ids(string ...$ids): static
    {
        $clone = clone $this;
        $clone->query['IDs'] = implode(',', $ids);

        return $clone;
    }

    public function unitDp(int $unitDp): static
    {
        $clone = clone $this;
        $clone->query['unitdp'] = $unitDp;

        return $clone;
    }

    public function createdByApp(bool $createdByApp = true): static
    {
        $clone = clone $this;
        $clone->query['createdByMyApp'] = $createdByApp ? 'true' : 'false';

        return $clone;
    }

    /**
     * @return array<string, scalar|array<int, scalar>|null>
     */
    protected function queryParameters(): array
    {
        return $this->query;
    }
}
