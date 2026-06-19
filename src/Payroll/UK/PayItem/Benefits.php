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

final class Benefits implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<Benefit>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Benefits')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $benefit): Benefit => $this->mapBenefit($benefit),
            Json::extractList($payload, 'benefits')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Benefit>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Benefits']);
    }

    public function find(string $benefitId): ?Benefit
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Benefits/' . $benefitId)
            ->send();

        $payload = $response->json();
        $benefit = Json::extractObject($payload, 'benefit');

        return $benefit !== [] ? $this->mapBenefit($benefit) : null;
    }

    public function create(Benefit $benefit, ?string $idempotencyKey = null): Benefit
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/Benefits')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($benefit->toRequest())
            ->send();

        $payload = $response->json();
        $created = Json::extractObject($payload, 'benefit');

        return $this->mapBenefit($created);
    }

    /**
     * @param array<string, mixed> $benefit
     */
    public function mapBenefit(array $benefit): Benefit
    {
        return (new Benefit())->fill($benefit);
    }
}
