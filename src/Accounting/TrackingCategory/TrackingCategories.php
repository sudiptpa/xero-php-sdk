<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\TrackingCategory;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class TrackingCategories implements DefinesScopes
{
    use BuildsQueries;
    use InteractsWithBindings;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.settings'],
            granular: ['accounting.settings.read', 'accounting.settings']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    public function includeArchived(bool $includeArchived = true): self
    {
        $clone = clone $this;
        $clone->query['includeArchived'] = $includeArchived ? 'true' : 'false';

        return $clone;
    }

    /**
     * @return ResourceCollection<TrackingCategory>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/TrackingCategories')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $trackingCategory): TrackingCategory => $this->mapTrackingCategory($trackingCategory),
            Json::extractList($payload, 'TrackingCategories')
        );

        return new ResourceCollection($items);
    }

    public function find(string $trackingCategoryId): ?TrackingCategory
    {
        $response = $this->client
            ->get('/api.xro/2.0/TrackingCategories/' . $trackingCategoryId)
            ->send();

        $payload = $response->json();
        $trackingCategory = Json::extractFirst($payload, 'TrackingCategories');

        return $trackingCategory !== null ? $this->mapTrackingCategory($trackingCategory) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $trackingCategoryId): Payload
    {
        return (new Payload($this->client))->id($trackingCategoryId);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapTrackingCategory(array $payload): TrackingCategory
    {
        return (new TrackingCategory($this->client))->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapOption(array $payload): Option
    {
        return (new Option())->fill($payload);
    }
}
