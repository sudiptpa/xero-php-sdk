<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class Contacts implements PaginatesResults, DefinesScopes
{
    use BuildsQueries;
    use HasPagination;
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

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $clone = clone $this;
        $clone->query['order'] = $field . ' ' . strtoupper($direction);

        return $clone;
    }

    public function includeArchived(bool $includeArchived = true): self
    {
        $clone = clone $this;
        $clone->query['includeArchived'] = $includeArchived ? 'true' : 'false';

        return $clone;
    }

    /**
     * @return ResourceCollection<Contact>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Contacts')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $contact): Contact => $this->mapContact($contact),
            Json::extractList($payload, 'Contacts')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<Contact>
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

        $items = $builder->get();

        return new PaginatedCollection(
            $items,
            $builder->currentPage(),
            $builder->currentPerPage(),
            [
                'path' => '/api.xro/2.0/Contacts',
            ]
        );
    }

    public function find(string $contactId): ?Contact
    {
        $response = $this->client
            ->get('/api.xro/2.0/Contacts/' . $contactId)
            ->send();

        $payload = $response->json();
        $contact = Json::extractFirst($payload, 'Contacts');

        return $contact !== null ? $this->mapContact($contact) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $contactId): Payload
    {
        return (new Payload($this->client))->id($contactId);
    }

    public function history(string $contactId): History
    {
        return new History($this->client, '/api.xro/2.0/Contacts/' . $contactId . '/History');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapContact(array $payload): Contact
    {
        return (new Contact($this->client))->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapAddress(array $payload): Address
    {
        return (new Address())->fill($payload);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapPhone(array $payload): Phone
    {
        return (new Phone())->fill($payload);
    }
}
