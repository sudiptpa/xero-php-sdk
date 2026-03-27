<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class PurchaseOrders implements PaginatesResults, DefinesScopes
{
    use BuildsQueries;
    use HasPagination;
    use InteractsWithBindings;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.transactions'],
            granular: ['accounting.transactions.read', 'accounting.transactions']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<PurchaseOrder>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/PurchaseOrders')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $purchaseOrder): PurchaseOrder => PurchaseOrder::fromPayload($purchaseOrder, $this->client),
            $payload['PurchaseOrders'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<PurchaseOrder>
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

        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/PurchaseOrders']);
    }

    public function find(string $purchaseOrderId): ?PurchaseOrder
    {
        $response = $this->client
            ->get('/api.xro/2.0/PurchaseOrders/' . $purchaseOrderId)
            ->send();

        $payload = $response->json();
        $purchaseOrder = $payload['PurchaseOrders'][0] ?? null;

        return is_array($purchaseOrder) ? PurchaseOrder::fromPayload($purchaseOrder, $this->client) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $purchaseOrderId): Payload
    {
        return (new Payload($this->client))->id($purchaseOrderId);
    }

    public function attachments(string $purchaseOrderId): Attachments
    {
        return new Attachments($this->client, $purchaseOrderId);
    }

    public function history(string $purchaseOrderId): History
    {
        return new History($this->client, '/api.xro/2.0/PurchaseOrders/' . $purchaseOrderId . '/History');
    }

    public function pdf(string $purchaseOrderId): string
    {
        $response = $this->client
            ->get('/api.xro/2.0/PurchaseOrders/' . $purchaseOrderId . '/pdf')
            ->withHeaders(['Accept' => 'application/pdf'])
            ->send();

        return $response->body;
    }
}
