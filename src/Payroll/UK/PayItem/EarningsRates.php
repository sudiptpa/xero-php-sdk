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

final class EarningsRates implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<EarningsRate>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/EarningsRates')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $earningsRate): EarningsRate => $this->mapEarningsRate($earningsRate),
            Json::extractList($payload, 'earningsRates')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<EarningsRate>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/EarningsRates']);
    }

    public function find(string $earningsRateId): ?EarningsRate
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/EarningsRates/' . $earningsRateId)
            ->send();

        $payload = $response->json();
        $earningsRate = Json::extractObject($payload, 'earningsRate');

        return $earningsRate !== [] ? $this->mapEarningsRate($earningsRate) : null;
    }

    public function create(EarningsRate $earningsRate, ?string $idempotencyKey = null): EarningsRate
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/EarningsRates')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($earningsRate->toRequest())
            ->send();

        $payload = $response->json();
        $created = Json::extractObject($payload, 'earningsRate');

        return $this->mapEarningsRate($created);
    }

    /**
     * @param array<string, mixed> $earningsRate
     */
    public function mapEarningsRate(array $earningsRate): EarningsRate
    {
        return (new EarningsRate())->fill($earningsRate);
    }
}
