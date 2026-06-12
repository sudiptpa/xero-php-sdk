<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayItem;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class EarningsOrders implements PaginatesResults, DefinesScopes
{
    use HasPagination;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.settings'],
            granular: ['payroll.settings.read', 'payroll.settings']
        );
    }

    /**
     * @return ResourceCollection<EarningsOrder>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/EarningsOrders')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $earningsOrder): EarningsOrder => $this->mapEarningsOrder($earningsOrder),
            Json::extractList($payload, 'statutoryDeductions')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<EarningsOrder>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        $builder = $this;

        if ($page !== null) {
            $builder = $builder->page($page);
        }

        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/EarningsOrders']);
    }

    public function find(string $earningsOrderId): ?EarningsOrder
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/EarningsOrders/' . $earningsOrderId)
            ->send();

        $payload = $response->json();
        $earningsOrder = Json::extractObject($payload, 'statutoryDeduction');

        return $earningsOrder !== [] ? $this->mapEarningsOrder($earningsOrder) : null;
    }

    /**
     * @param array<string, mixed> $earningsOrder
     */
    public function mapEarningsOrder(array $earningsOrder): EarningsOrder
    {
        return (new EarningsOrder())->fill($earningsOrder);
    }
}
