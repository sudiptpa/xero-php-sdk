<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ContactGroup;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class ContactGroups implements DefinesScopes
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
            broad: ['accounting.contacts'],
            granular: ['accounting.contacts.read', 'accounting.contacts']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<ContactGroup>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/ContactGroups')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $contactGroup): ContactGroup => $this->mapContactGroup($contactGroup),
            Json::extractList($payload, 'ContactGroups')
        );

        return new ResourceCollection($items);
    }

    public function find(string $contactGroupId): ?ContactGroup
    {
        $response = $this->client
            ->get('/api.xro/2.0/ContactGroups/' . $contactGroupId)
            ->send();

        $payload = $response->json();
        $raw = Json::extractObject($payload, 'ContactGroup');
        $contactGroup = Json::extractFirst($payload, 'ContactGroups') ?? ($raw !== [] ? $raw : null);

        return $contactGroup !== null ? $this->mapContactGroup($contactGroup) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $contactGroupId): Payload
    {
        return (new Payload($this->client))->id($contactGroupId);
    }

    public function contacts(string $contactGroupId): ContactAssignments
    {
        return new ContactAssignments($this->client, $contactGroupId);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapContactGroup(array $payload): ContactGroup
    {
        return (new ContactGroup($this->client))->fill($payload);
    }
}
