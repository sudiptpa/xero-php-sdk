<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\User;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

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
        $items = array_values(array_map(
            fn (array $user): User => $this->mapUser($user),
            $payload['Users'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapUser(array $payload): User
    {
        return (new User())
            ->setUserID(isset($payload['UserID']) ? (string) $payload['UserID'] : null)
            ->setFirstName(isset($payload['FirstName']) ? (string) $payload['FirstName'] : null)
            ->setLastName(isset($payload['LastName']) ? (string) $payload['LastName'] : null)
            ->setEmailAddress(isset($payload['EmailAddress']) ? (string) $payload['EmailAddress'] : null)
            ->setIsSubscriber(isset($payload['IsSubscriber']) ? (bool) $payload['IsSubscriber'] : null);
    }
}
