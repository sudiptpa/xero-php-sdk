<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayItem;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Superannuations implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<Superannuation>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Superannuations')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $superannuation): Superannuation => $this->mapSuperannuation($superannuation),
            Json::extractList($payload, 'benefits')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Superannuation>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Superannuations']);
    }

    public function find(string $superannuationId): ?Superannuation
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Superannuations/' . $superannuationId)
            ->send();

        $payload = $response->json();
        $superannuation = Json::extractObject($payload, 'benefit');

        return $superannuation !== [] ? $this->mapSuperannuation($superannuation) : null;
    }

    public function create(Superannuation $superannuation, ?string $idempotencyKey = null): Superannuation
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/Superannuations')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($superannuation->toRequest())
            ->send();

        $payload = $response->json();
        $created = Json::extractObject($payload, 'benefit');

        return $this->mapSuperannuation($created);
    }

    /**
     * @param array<string, mixed> $superannuation
     */
    public function mapSuperannuation(array $superannuation): Superannuation
    {
        return (new Superannuation())->fill($superannuation);
    }
}
