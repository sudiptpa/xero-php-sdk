<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Concerns\HasPagination;

final class Employees implements PaginatesResults
{
    use HasPagination;

    public function __construct(
        private readonly Client $client
    ) {
    }

    /**
     * @return ResourceCollection<Employee>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/Employees')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $employee): Employee => Employee::fromArray($employee),
            $payload['Employees'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Employee>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedResult
    {
        $builder = $this;

        if ($page !== null) {
            $builder = $builder->page($page);
        }

        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        $items = $builder->get();

        return new PaginatedResult(
            $items,
            $builder->currentPage(),
            $builder->currentPerPage(),
            [
                'path' => '/payroll.xro/1.0/Employees',
            ]
        );
    }
}
