<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\LinkedTransaction;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class LinkedTransactions implements DefinesScopes
{
    use HasPagination;

    /**
     * @var array<string, scalar|array<int, scalar>|null>
     */
    private array $filters = [];

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['accounting.transactions'],
            granular: ['accounting.transactions.read', 'accounting.transactions']
        );
    }

    public function linkedTransactionId(string $id): self
    {
        $clone = clone $this;
        $clone->filters['LinkedTransactionID'] = $id;

        return $clone;
    }

    public function sourceTransaction(string $id): self
    {
        $clone = clone $this;
        $clone->filters['SourceTransactionID'] = $id;

        return $clone;
    }

    public function targetTransaction(string $id): self
    {
        $clone = clone $this;
        $clone->filters['TargetTransactionID'] = $id;

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->filters['ContactID'] = $contactId;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->filters['Status'] = strtoupper($status);

        return $clone;
    }

    /**
     * @return ResourceCollection<LinkedTransaction>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/LinkedTransactions')
            ->withQuery(array_merge($this->filters, $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $linkedTransaction): LinkedTransaction => LinkedTransaction::fromArray($linkedTransaction),
            $payload['LinkedTransactions'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }
}
