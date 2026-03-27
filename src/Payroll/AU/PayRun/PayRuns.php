<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class PayRuns implements PaginatesResults, DefinesScopes
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
            broad: ['payroll.payruns'],
            granular: ['payroll.payruns.read', 'payroll.payruns']
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
     * @return ResourceCollection<PayRun>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/PayRuns')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $payRun): PayRun => PayRun::fromArray($payRun, $this->client),
            $payload['PayRuns'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<PayRun>
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

        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/1.0/PayRuns']);
    }

    public function find(string $payRunId): ?PayRun
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/PayRuns/' . $payRunId)
            ->send();

        $payload = $response->json();
        $payRun = $payload['PayRuns'][0] ?? $payload['PayRun'] ?? null;

        return is_array($payRun) ? PayRun::fromArray($payRun, $this->client) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $payRunId): Payload
    {
        return (new Payload($this->client))->id($payRunId);
    }
}
