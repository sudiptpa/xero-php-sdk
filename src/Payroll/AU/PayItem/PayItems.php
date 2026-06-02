<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayItem;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ScopeRequirements;

final class PayItems implements PaginatesResults, DefinesScopes
{
    use HasPagination;

    /**
     * @var array<string, scalar|array<int, scalar>|null>
     */
    private array $query = [];

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

    public function modifiedSince(DateTimeInterface $date): self
    {
        $clone = clone $this;
        $clone->query['If-Modified-Since'] = $date->format(DateTimeInterface::ATOM);

        return $clone;
    }

    public function where(string $where): self
    {
        $clone = clone $this;
        $clone->query['where'] = $where;

        return $clone;
    }

    public function orderBy(string $order): self
    {
        $clone = clone $this;
        $clone->query['order'] = $order;

        return $clone;
    }

    /**
     * @return ResourceCollection<PayItem>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/PayItems')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $payItems = Json::extractList($payload, 'PayItems');
        $items = array_map(
            fn (array $payItem): PayItem => $this->mapPayItem($payItem),
            $payItems !== [] ? $payItems : [$payload]
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<PayItem>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/1.0/PayItems']);
    }

    /**
     * @param array<string, mixed> $payItem
     */
    public function mapPayItem(array $payItem): PayItem
    {
        return (new PayItem())->fill($payItem);
    }
}
