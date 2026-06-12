<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\Timesheet;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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
        $clone->query['status'] = $status;

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
        $items = array_map(
            fn (array $timesheet): Timesheet => $this->mapTimesheet($timesheet),
            Json::extractList($payload, 'timesheets')
        );

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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/Timesheets']);
    }

    public function find(string $timesheetId): ?Timesheet
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/Timesheets/' . $timesheetId)
            ->send();

        $payload = $response->json();
        $timesheet = Json::extractFirst($payload, 'timesheets') ?? Json::extractObject($payload, 'timesheet') ?: null;

        return $timesheet !== null ? $this->mapTimesheet($timesheet) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function approve(string $timesheetId): Timesheet
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Approve')
            ->send();

        $payload = $response->json();
        $timesheet = Json::extractFirst($payload, 'timesheets') ?? Json::extractObject($payload, 'timesheet');

        return $timesheet !== [] ? $this->mapTimesheet($timesheet) : new Timesheet($this->client);
    }

    public function revert(string $timesheetId): Timesheet
    {
        $response = $this->client
            ->post('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/RevertToDraft')
            ->send();

        $payload = $response->json();
        $timesheet = Json::extractFirst($payload, 'timesheets') ?? Json::extractObject($payload, 'timesheet');

        return $timesheet !== [] ? $this->mapTimesheet($timesheet) : new Timesheet($this->client);
    }

    public function delete(string $timesheetId): bool
    {
        $this->client
            ->delete('/payroll.xro/2.0/Timesheets/' . $timesheetId)
            ->send();

        return true;
    }

    public function createLine(string $timesheetId, TimesheetLine $line, ?string $idempotencyKey = null): TimesheetLine
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Lines')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($line->toRequest())
            ->send()
            ->json();

        return (new TimesheetLine())->fill(Json::extractObject($payload, 'timesheetLine'));
    }

    public function updateLine(string $timesheetId, string $timesheetLineId, TimesheetLine $line, ?string $idempotencyKey = null): TimesheetLine
    {
        $payload = $this->client
            ->put('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Lines/' . $timesheetLineId)
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($line->toRequest())
            ->send()
            ->json();

        return (new TimesheetLine())->fill(Json::extractObject($payload, 'timesheetLine'));
    }

    public function deleteLine(string $timesheetId, string $timesheetLineId): bool
    {
        $this->client
            ->delete('/payroll.xro/2.0/Timesheets/' . $timesheetId . '/Lines/' . $timesheetLineId)
            ->send();

        return true;
    }

    /**
     * @param array<string, mixed> $timesheet
     */
    public function mapTimesheet(array $timesheet): Timesheet
    {
        return (new Timesheet($this->client))->fill($timesheet);
    }
}
