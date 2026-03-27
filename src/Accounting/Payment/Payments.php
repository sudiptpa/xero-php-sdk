<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

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

final class Payments implements PaginatesResults, DefinesScopes
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
            granular: ['accounting.payments.read', 'accounting.payments']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<Payment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Payments')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $payment): Payment => Payment::fromArray($payment, $this->client),
            $payload['Payments'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Payment>
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

        return new PaginatedResult(
            $builder->get(),
            $builder->currentPage(),
            $builder->currentPerPage(),
            ['path' => '/api.xro/2.0/Payments']
        );
    }

    public function find(string $paymentId): ?Payment
    {
        $response = $this->client
            ->get('/api.xro/2.0/Payments/' . $paymentId)
            ->send();

        $payload = $response->json();
        $payment = $payload['Payments'][0] ?? null;

        return is_array($payment) ? Payment::fromArray($payment, $this->client) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $paymentId): Payload
    {
        return (new Payload($this->client))->id($paymentId);
    }

    public function history(string $paymentId): History
    {
        return new History($this->client, '/api.xro/2.0/Payments/' . $paymentId . '/History');
    }
}
