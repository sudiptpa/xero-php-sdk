<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransaction;

use Sujip\Xero\Accounting\Attachments;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class BankTransactions implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<BankTransaction>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/BankTransactions')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $bankTransaction): BankTransaction => $this->mapBankTransaction($bankTransaction),
            Json::extractList($payload, 'BankTransactions')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<BankTransaction>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/api.xro/2.0/BankTransactions']);
    }

    public function find(string $bankTransactionId): ?BankTransaction
    {
        $response = $this->client
            ->get('/api.xro/2.0/BankTransactions/' . $bankTransactionId)
            ->send();

        $payload = $response->json();
        $bankTransaction = Json::extractFirst($payload, 'BankTransactions');

        return $bankTransaction !== null ? $this->mapBankTransaction($bankTransaction) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $bankTransactionId): Payload
    {
        return (new Payload($this->client))->id($bankTransactionId);
    }

    public function history(string $bankTransactionId): History
    {
        return new History($this->client, '/api.xro/2.0/BankTransactions/' . $bankTransactionId . '/History');
    }

    public function attachments(string $bankTransactionId): Attachments
    {
        return new Attachments($this->client, '/api.xro/2.0/BankTransactions/' . $bankTransactionId . '/Attachments');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapBankTransaction(array $payload): BankTransaction
    {
        return (new BankTransaction($this->client))->fill($payload);
    }
}
