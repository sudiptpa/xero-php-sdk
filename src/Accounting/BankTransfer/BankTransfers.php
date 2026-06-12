<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransfer;

use Sujip\Xero\Accounting\Attachments;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class BankTransfers implements DefinesScopes
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
     * @return ResourceCollection<BankTransfer>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/BankTransfers')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $bankTransfer): BankTransfer => $this->mapBankTransfer($bankTransfer),
            Json::extractList($payload, 'BankTransfers')
        );

        return new ResourceCollection($items);
    }

    public function find(string $bankTransferId): ?BankTransfer
    {
        $response = $this->client
            ->get('/api.xro/2.0/BankTransfers/' . $bankTransferId)
            ->send();

        $payload = $response->json();
        $bankTransfer = Json::extractFirst($payload, 'BankTransfers');

        return $bankTransfer !== null ? $this->mapBankTransfer($bankTransfer) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function history(string $bankTransferId): History
    {
        return new History($this->client, '/api.xro/2.0/BankTransfers/' . $bankTransferId . '/History');
    }

    public function attachments(string $bankTransferId): Attachments
    {
        return new Attachments($this->client, '/api.xro/2.0/BankTransfers/' . $bankTransferId . '/Attachments');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapBankTransfer(array $payload): BankTransfer
    {
        return (new BankTransfer($this->client))->fill($payload);
    }
}
