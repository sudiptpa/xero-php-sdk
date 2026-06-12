<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\User;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class Users implements DefinesScopes
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

    /**
     * @return ResourceCollection<User>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Users')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $user): User => $this->mapUser($user),
            Json::extractList($payload, 'Users')
        );

        return new ResourceCollection($items);
    }

    public function find(string $userId): ?User
    {
        $response = $this->client
            ->get('/api.xro/2.0/Users/' . $userId)
            ->send();

        $payload = $response->json();
        $user = Json::extractFirst($payload, 'Users');

        return $user !== null ? $this->mapUser($user) : null;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapUser(array $payload): User
    {
        return (new User())->fill($payload);
    }
}
