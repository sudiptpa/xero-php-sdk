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

final class Deductions implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<Deduction>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Deductions')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $deduction): Deduction => $this->mapDeduction($deduction),
            Json::extractList($payload, 'deductions')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Deduction>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Deductions']);
    }

    public function find(string $deductionId): ?Deduction
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Deductions/' . $deductionId)
            ->send();

        $payload = $response->json();
        $deduction = Json::extractObject($payload, 'deduction');

        return $deduction !== [] ? $this->mapDeduction($deduction) : null;
    }

    public function create(Deduction $deduction, ?string $idempotencyKey = null): Deduction
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/Deductions')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($deduction->toRequest())
            ->send();

        $payload = $response->json();
        $created = Json::extractObject($payload, 'deduction');

        return $this->mapDeduction($created);
    }

    /**
     * @param array<string, mixed> $deduction
     */
    public function mapDeduction(array $deduction): Deduction
    {
        return (new Deduction())->fill($deduction);
    }
}
