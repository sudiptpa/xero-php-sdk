<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Task;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Tasks implements PaginatesResults, DefinesScopes
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

    public function ids(string ...$taskIds): self
    {
        $clone = clone $this;
        $clone->query['taskIds'] = implode(',', $taskIds);

        return $clone;
    }

    public function chargeType(string $chargeType): self
    {
        $clone = clone $this;
        $clone->query['chargeType'] = strtoupper($chargeType);

        return $clone;
    }

    /**
     * @return ResourceCollection<Task>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/projects.xro/2.0/Projects/' . $this->projectId . '/Tasks')
            ->withQuery(array_merge($this->query, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(fn (array $task): Task => $this->mapTask($task), self::many($payload));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Task>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/projects.xro/2.0/Projects/' . $this->projectId . '/Tasks']);
    }

    public function find(string $taskId): ?Task
    {
        $response = $this->client
            ->get('/projects.xro/2.0/Projects/' . $this->projectId . '/Tasks/' . $taskId)
            ->send();

        $payload = $response->json();
        $task = self::single($payload);

        return is_array($task) ? $this->mapTask($task) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client, $this->projectId);
    }

    public function update(string $taskId): Payload
    {
        return (new Payload($this->client, $this->projectId))->id($taskId);
    }

    public function delete(string $taskId): void
    {
        $this->client
            ->delete('/projects.xro/2.0/Projects/' . $this->projectId . '/Tasks/' . $taskId)
            ->send();
    }

    /**
     * @param array<string, mixed> $payload
     * @return list<array<string, mixed>>
     */
    public static function many(array $payload): array
    {
        $items = $payload['Tasks'] ?? $payload['tasks'] ?? $payload['Items'] ?? $payload['items'] ?? [];

        return array_values(array_filter($items, 'is_array'));
    }

    /**
     * @param array<string, mixed> $payload
     * @return array<string, mixed>|null
     */
    public static function single(array $payload): ?array
    {
        $item = $payload['Task'] ?? $payload['task'] ?? self::many($payload)[0] ?? null;

        return is_array($item) ? $item : null;
    }

    /**
     * @param array<string, mixed> $task
     */
    public function mapTask(array $task): Task
    {
        return (new Task($this->client))
            ->fill($task)
            ->setProjectID($this->projectId);
    }
}
