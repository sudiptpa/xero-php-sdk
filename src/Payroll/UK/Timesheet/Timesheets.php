<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Timesheet;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
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

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->query['status'] = strtoupper($status);

        return $clone;
    }

    /**
     * @return ResourceCollection<Timesheet>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Timesheets')
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
     * @return PaginatedResult<Timesheet>
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

        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Timesheets']);
    }

    public function find(string $timesheetId): ?Timesheet
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Timesheets/' . $timesheetId)
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

    public function approve(string $timesheetId): Timesheet
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Approve')
            ->send();

        $payload = $response->json();
        $timesheet = $payload['Timesheets'][0] ?? $payload['Timesheet'] ?? [];

        return is_array($timesheet) ? $this->mapTimesheet($timesheet) : new Timesheet($this->client);
    }

    public function revert(string $timesheetId): Timesheet
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Revert')
            ->send();

        $payload = $response->json();
        $timesheet = $payload['Timesheets'][0] ?? $payload['Timesheet'] ?? [];

        return is_array($timesheet) ? $this->mapTimesheet($timesheet) : new Timesheet($this->client);
    }

    /**
     * @param array<string, mixed> $timesheet
     */
    public function mapTimesheet(array $timesheet): Timesheet
    {
        return (new Timesheet($this->client))
            ->setTimesheetID($timesheet['TimesheetID'] ?? null)
            ->setEmployeeID($timesheet['EmployeeID'] ?? null)
            ->setStartDate($timesheet['StartDate'] ?? null)
            ->setEndDate($timesheet['EndDate'] ?? null)
            ->setStatus($timesheet['Status'] ?? null)
            ;
    }
}
