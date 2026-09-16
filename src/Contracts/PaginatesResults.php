<?php

declare(strict_types=1);

namespace Sujip\Xero\Contracts;

interface PaginatesResults
{
    public function page(int $page): static;

    public function perPage(int $perPage): static;
}
