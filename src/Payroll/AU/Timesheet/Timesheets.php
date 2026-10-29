<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\Timesheet;

use Sujip\Xero\Client;
use Sujip\Xero\Concerns\HasPagination;
use Sujip\Xero\Contracts\DefinesScopes;
use Sujip\Xero\Contracts\PaginatesResults;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Timesheets implements PaginatesResults, DefinesScopes
{
    use HasPagination;

    /** @var array<string, scalar|array<int, scalar>|null> */
    private array $query = [];

    public function __construct(private readonly Client $client)
    {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.timesheets'],
            granular: ['payroll.timesheets.read', 'payroll.timesheets']
        );
    }

    public function filter(string $filter): self
    {
        $clone = clone $this;
        $clone->query['filter'] = $filter;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->query['status'] = $status;

        return $clone;
    }

    public function startDate(string $date): self
    {
        $clone = clone $this;
        $clone->query['startDate'] = $date;

        return $clone;
    }

    public function endDate(string $date): self
    {
        $clone = clone $this;
        $clone->query['endDate'] = $date;

        return $clone;
    }

    public function sort(string $sort): self
    {
        $clone = clone $this;
        $clone->query['sort'] = $sort;

        return $clone;
    }

    /** @return ResourceCollection<Timesheet> */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Timesheets')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send()
            ->json();

        $items = array_map(
            fn (array $timesheet): Timesheet => $this->mapTimesheet($timesheet),
            Json::extractList($payload, 'timesheets')
        );

        return new ResourceCollection($items);
    }

    /** @return PaginatedCollection<Timesheet> */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        $builder = $this;
        if ($page !== null) {
            $builder = $builder->page($page);
        }
        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Timesheets']);
    }

    public function find(string $timesheetId): ?Timesheet
    {
        $payload = $this->client->get('/payroll.xro/2.0/Timesheets/' . $timesheetId)->send()->json();
        $timesheet = Json::extractFirstOrObject($payload, 'timesheets', 'timesheet');

        return $timesheet !== null ? $this->mapTimesheet($timesheet) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function approve(string $timesheetId, ?string $idempotencyKey = null): Timesheet
    {
        return $this->transition($timesheetId, 'Approve', $idempotencyKey);
    }

    public function revert(string $timesheetId, ?string $idempotencyKey = null): Timesheet
    {
        return $this->transition($timesheetId, 'RevertToDraft', $idempotencyKey);
    }

    public function delete(string $timesheetId): bool
    {
        $this->client->delete('/payroll.xro/2.0/Timesheets/' . $timesheetId)->send();

        return true;
    }

    public function createLine(string $timesheetId, TimesheetLine $line, ?string $idempotencyKey = null): TimesheetLine
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Lines')
            ->withHeaders($this->idempotencyHeaders($idempotencyKey))
            ->withJson($line->toRequest())
            ->send()
            ->json();

        return (new TimesheetLine())->fill(Json::extractObject($payload, 'timesheetLine'));
    }

    public function updateLine(string $timesheetId, string $timesheetLineId, TimesheetLine $line, ?string $idempotencyKey = null): TimesheetLine
    {
        $payload = $this->client
            ->put('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Lines/' . $timesheetLineId)
            ->withHeaders($this->idempotencyHeaders($idempotencyKey))
            ->withJson($line->toRequest())
            ->send()
            ->json();

        return (new TimesheetLine())->fill(Json::extractObject($payload, 'timesheetLine'));
    }

    public function deleteLine(string $timesheetId, string $timesheetLineId): bool
    {
        $this->client->delete('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Lines/' . $timesheetLineId)->send();

        return true;
    }

    /** @param array<string, mixed> $timesheet */
    public function mapTimesheet(array $timesheet): Timesheet
    {
        return (new Timesheet($this->client))->fill($timesheet);
    }

    private function transition(string $timesheetId, string $action, ?string $idempotencyKey): Timesheet
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/' . $action)
            ->withHeaders($this->idempotencyHeaders($idempotencyKey))
            ->send()
            ->json();
        $timesheet = Json::extractFirstOrObject($payload, 'timesheets', 'timesheet');

        return $timesheet !== null ? $this->mapTimesheet($timesheet) : new Timesheet($this->client);
    }

    /** @return array<string, string> */
    private function idempotencyHeaders(?string $key): array
    {
        return $key === null ? [] : ['Idempotency-Key' => $key];
    }
}
