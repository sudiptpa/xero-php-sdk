<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\TimeEntry;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ScopeRequirements;

final class TimeEntries implements PaginatesResults, DefinesScopes
{
    use HasPagination;

    /**
     * @var array<string, scalar|array<int, scalar>|null>
     */
    private array $query = [];

    public function __construct(
        private readonly Client $client,
        private readonly string $projectId
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['projects'],
            granular: ['projects.read', 'projects']
        );
    }

    public function user(string $userId): self
    {
        $clone = clone $this;
        $clone->query['userId'] = $userId;

        return $clone;
    }

    public function task(string $taskId): self
    {
        $clone = clone $this;
        $clone->query['taskId'] = $taskId;

        return $clone;
    }

    public function invoice(string $invoiceId): self
    {
        $clone = clone $this;
        $clone->query['invoiceId'] = $invoiceId;

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->query['contactId'] = $contactId;

        return $clone;
    }

    public function states(string ...$states): self
    {
        $clone = clone $this;
        $clone->query['states'] = implode(',', array_map('strtoupper', $states));

        return $clone;
    }

    public function isChargeable(bool $chargeable = true): self
    {
        $clone = clone $this;
        $clone->query['isChargeable'] = $chargeable ? 'true' : 'false';

        return $clone;
    }

    public function dateAfterUtc(DateTimeInterface|string $date): self
    {
        $clone = clone $this;
        $clone->query['dateAfterUtc'] = $date instanceof DateTimeInterface ? $date->format(DateTimeInterface::ATOM) : $date;

        return $clone;
    }

    public function dateBeforeUtc(DateTimeInterface|string $date): self
    {
        $clone = clone $this;
        $clone->query['dateBeforeUtc'] = $date instanceof DateTimeInterface ? $date->format(DateTimeInterface::ATOM) : $date;

        return $clone;
    }

    /**
     * @return ResourceCollection<TimeEntry>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/projects.xro/2.0/Projects/' . $this->projectId . '/Time')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(fn (array $timeEntry): TimeEntry => $this->mapTimeEntry($timeEntry), self::many($payload));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<TimeEntry>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/projects.xro/2.0/Projects/' . $this->projectId . '/Time']);
    }

    public function find(string $timeEntryId): ?TimeEntry
    {
        $response = $this->client
            ->get('/projects.xro/2.0/Projects/' . $this->projectId . '/Time/' . $timeEntryId)
            ->send();

        $payload = $response->json();
        $timeEntry = self::single($payload);

        return is_array($timeEntry) ? $this->mapTimeEntry($timeEntry) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client, $this->projectId);
    }

    public function update(string $timeEntryId): Payload
    {
        return (new Payload($this->client, $this->projectId))->id($timeEntryId);
    }

    public function delete(string $timeEntryId): void
    {
        $this->client
            ->delete('/projects.xro/2.0/Projects/' . $this->projectId . '/Time/' . $timeEntryId)
            ->send();
    }

    /**
     * @param array<string, mixed> $payload
     * @return list<array<string, mixed>>
     */
    public static function many(array $payload): array
    {
        return Json::extractList($payload, 'TimeEntries')
            ?: Json::extractList($payload, 'timeEntries')
            ?: Json::extractList($payload, 'Items')
            ?: Json::extractList($payload, 'items');
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>|null
     */
    public static function single(array $payload): ?array
    {
        return Json::extractObject($payload, 'TimeEntry')
            ?: Json::extractObject($payload, 'timeEntry')
            ?: self::many($payload)[0]
            ?? null;
    }

    /**
     * @param array<string, mixed> $timeEntry
     */
    public function mapTimeEntry(array $timeEntry): TimeEntry
    {
        return (new TimeEntry($this->client))
            ->fill($timeEntry)
            ->setProjectID($this->projectId);
    }
}
