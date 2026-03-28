<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Contact;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\ScopeRequirements;

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
        $items = array_values(array_map(
            fn (array $contact): Contact => $this->mapContact($contact),
            $payload['Contacts'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Contact>
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

        $items = $builder->get();

        return new PaginatedResult(
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
        $contact = $payload['Contacts'][0] ?? null;

        return is_array($contact) ? $this->mapContact($contact) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $contactId): Payload
    {
        return (new Payload($this->client))->id($contactId);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapContact(array $payload): Contact
    {
        $contact = (new Contact($this->client))
            ->setContactID(isset($payload['ContactID']) ? (string) $payload['ContactID'] : null)
            ->setName(isset($payload['Name']) ? (string) $payload['Name'] : null)
            ->setFirstName(isset($payload['FirstName']) ? (string) $payload['FirstName'] : null)
            ->setLastName(isset($payload['LastName']) ? (string) $payload['LastName'] : null)
            ->setEmailAddress(isset($payload['EmailAddress']) ? (string) $payload['EmailAddress'] : null);

        foreach ($payload['Addresses'] ?? [] as $address) {
            if (is_array($address)) {
                $contact->addAddress($this->mapAddress($address));
            }
        }

        foreach ($payload['Phones'] ?? [] as $phone) {
            if (is_array($phone)) {
                $contact->addPhone($this->mapPhone($phone));
            }
        }

        return $contact;
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapAddress(array $payload): Address
    {
        return (new Address())
            ->setAddressType(isset($payload['AddressType']) ? (string) $payload['AddressType'] : null)
            ->setAddressLine1(isset($payload['AddressLine1']) ? (string) $payload['AddressLine1'] : null)
            ->setAddressLine2(isset($payload['AddressLine2']) ? (string) $payload['AddressLine2'] : null)
            ->setCity(isset($payload['City']) ? (string) $payload['City'] : null)
            ->setRegion(isset($payload['Region']) ? (string) $payload['Region'] : null)
            ->setPostalCode(isset($payload['PostalCode']) ? (string) $payload['PostalCode'] : null)
            ->setCountry(isset($payload['Country']) ? (string) $payload['Country'] : null);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapPhone(array $payload): Phone
    {
        return (new Phone())
            ->setPhoneType(isset($payload['PhoneType']) ? (string) $payload['PhoneType'] : null)
            ->setPhoneNumber(isset($payload['PhoneNumber']) ? (string) $payload['PhoneNumber'] : null)
            ->setPhoneAreaCode(isset($payload['PhoneAreaCode']) ? (string) $payload['PhoneAreaCode'] : null)
            ->setPhoneCountryCode(isset($payload['PhoneCountryCode']) ? (string) $payload['PhoneCountryCode'] : null);
    }
}
