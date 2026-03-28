<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class RepeatingInvoices implements DefinesScopes
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
     * @return ResourceCollection<RepeatingInvoice>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/RepeatingInvoices')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $repeatingInvoice): RepeatingInvoice => $this->mapRepeatingInvoice($repeatingInvoice),
            $payload['RepeatingInvoices'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $repeatingInvoiceId): ?RepeatingInvoice
    {
        $response = $this->client
            ->get('/api.xro/2.0/RepeatingInvoices/' . $repeatingInvoiceId)
            ->send();

        $payload = $response->json();
        $repeatingInvoice = $payload['RepeatingInvoices'][0] ?? null;

        return is_array($repeatingInvoice) ? $this->mapRepeatingInvoice($repeatingInvoice) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $repeatingInvoiceId): Payload
    {
        return (new Payload($this->client))->id($repeatingInvoiceId);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapRepeatingInvoice(array $payload): RepeatingInvoice
    {
        return (new RepeatingInvoice($this->client))
            ->setRepeatingInvoiceID(isset($payload['RepeatingInvoiceID']) ? (string) $payload['RepeatingInvoiceID'] : null)
            ->setType(isset($payload['Type']) ? (string) $payload['Type'] : null)
            ->setStatus(isset($payload['Status']) ? (string) $payload['Status'] : null)
            ->setReference(isset($payload['Reference']) ? (string) $payload['Reference'] : null)
            ;
    }
}
