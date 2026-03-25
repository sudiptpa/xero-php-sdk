<?php

declare(strict_types=1);

namespace Sujip\Xero\Support\Concerns;

trait HasPagination
{
    private ?int $page = null;

    private ?int $perPage = null;

    public function page(int $page): static
    {
        $clone = clone $this;
        $clone->page = $page;

        return $clone;
    }

    public function perPage(int $perPage): static
    {
        $clone = clone $this;
        $clone->perPage = $perPage;

        return $clone;
    }

    /**
     * @return array<string, scalar|array<int, scalar>|null>
     */
    protected function paginationQuery(): array
    {
        $query = [];

        if ($this->page !== null) {
            $query['page'] = $this->page;
        }

        if ($this->perPage !== null) {
            $query['pageSize'] = $this->perPage;
        }

        return $query;
    }

    protected function currentPage(): ?int
    {
        return $this->page;
    }

    protected function currentPerPage(): ?int
    {
        return $this->perPage;
    }
}
