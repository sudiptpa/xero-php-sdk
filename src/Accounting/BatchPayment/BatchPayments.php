<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BatchPayment;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class BatchPayments implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<BatchPayment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/BatchPayments')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $batchPayment): BatchPayment => $this->mapBatchPayment($batchPayment),
            Json::extractList($payload, 'BatchPayments')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<BatchPayment>
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
        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/BatchPayments']);
    }

    public function find(string $batchPaymentId): ?BatchPayment
    {
        $response = $this->client
            ->get('/api.xro/2.0/BatchPayments/' . $batchPaymentId)
            ->send();

        $payload = $response->json();
        $batchPayment = Json::extractFirst($payload, 'BatchPayments');

        return $batchPayment !== null ? $this->mapBatchPayment($batchPayment) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function history(string $batchPaymentId): History
    {
        return new History($this->client, '/api.xro/2.0/BatchPayments/' . $batchPaymentId . '/History');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapBatchPayment(array $payload): BatchPayment
    {
        return (new BatchPayment($this->client))->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapPaymentEntry(array $payload): PaymentEntry
    {
        return (new PaymentEntry())->fill($payload);
    }
}
