<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Receipts implements DefinesScopes
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
            broad: ['accounting.transactions'],
            granular: ['accounting.transactions.read', 'accounting.transactions']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<Receipt>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Receipts')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            static fn (array $receipt): Receipt => Receipt::fromArray($receipt),
            $payload['Receipts'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $receiptId): ?Receipt
    {
        $response = $this->client
            ->get('/api.xro/2.0/Receipts/' . $receiptId)
            ->send();

        $payload = $response->json();
        $receipt = $payload['Receipts'][0] ?? null;

        return is_array($receipt) ? Receipt::fromArray($receipt) : null;
    }

    public function history(string $receiptId): History
    {
        return new History($this->client, '/api.xro/2.0/Receipts/' . $receiptId . '/History');
    }
}
