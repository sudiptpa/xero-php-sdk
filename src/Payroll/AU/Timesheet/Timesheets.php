<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Timesheets implements PaginatesResults, DefinesScopes
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
            broad: ['payroll.timesheets'],
            granular: ['payroll.timesheets.read', 'payroll.timesheets']
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
     * @return ResourceCollection<Timesheet>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/Timesheets')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $timesheet): Timesheet => $this->mapTimesheet($timesheet),
            $payload['Timesheets'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Timesheet>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/1.0/Timesheets']);
    }

    public function find(string $timesheetId): ?Timesheet
    {
        $response = $this->client
            ->get('/payroll.xro/1.0/Timesheets/' . $timesheetId)
            ->send();

        $payload = $response->json();
        $timesheet = $payload['Timesheets'][0] ?? $payload['Timesheet'] ?? null;

        return is_array($timesheet) ? $this->mapTimesheet($timesheet) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $timesheetId): Payload
    {
        return (new Payload($this->client))->id($timesheetId);
    }

    /**
     * @param array<string, mixed> $timesheet
     */
    public function mapTimesheet(array $timesheet): Timesheet
    {
        return (new Timesheet($this->client))->fill($timesheet);
    }
}
