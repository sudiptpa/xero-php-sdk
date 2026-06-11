<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->query['status'] = $status;

        return $clone;
    }

    /**
     * @return ResourceCollection<PayRun>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/PayRuns')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $payRun): PayRun => $this->mapPayRun($payRun),
            Json::extractList($payload, 'payRuns')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<PayRun>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/PayRuns']);
    }

    public function find(string $payRunId): ?PayRun
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/PayRuns/' . $payRunId)
            ->send();

        $payload = $response->json();
        $payRun = Json::extractFirst($payload, 'payRuns') ?? Json::extractObject($payload, 'payRun') ?: null;

        return $payRun !== null ? $this->mapPayRun($payRun) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function payslips(string $payRunId): Payslips
    {
        return new Payslips($this->client, $payRunId);
    }

    /**
     * @param array<string, mixed> $payRun
     */
    public function mapPayRun(array $payRun): PayRun
    {
        return (new PayRun($this->client))->fill($payRun);
    }
}
