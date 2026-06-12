<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use Sujip\Xero\Accounting\Attachments;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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
        $items = array_map(
            fn (array $repeatingInvoice): RepeatingInvoice => $this->mapRepeatingInvoice($repeatingInvoice),
            Json::extractList($payload, 'RepeatingInvoices')
        );

        return new ResourceCollection($items);
    }

    public function find(string $repeatingInvoiceId): ?RepeatingInvoice
    {
        $response = $this->client
            ->get('/api.xro/2.0/RepeatingInvoices/' . $repeatingInvoiceId)
            ->send();

        $payload = $response->json();
        $repeatingInvoice = Json::extractFirst($payload, 'RepeatingInvoices');

        return $repeatingInvoice !== null ? $this->mapRepeatingInvoice($repeatingInvoice) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $repeatingInvoiceId): Payload
    {
        return (new Payload($this->client))->id($repeatingInvoiceId);
    }

    public function history(string $repeatingInvoiceId): History
    {
        return new History($this->client, '/api.xro/2.0/RepeatingInvoices/' . $repeatingInvoiceId . '/History');
    }

    public function attachments(string $repeatingInvoiceId): Attachments
    {
        return new Attachments($this->client, '/api.xro/2.0/RepeatingInvoices/' . $repeatingInvoiceId . '/Attachments');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapRepeatingInvoice(array $payload): RepeatingInvoice
    {
        return (new RepeatingInvoice($this->client))->fill($payload);
    }
}
