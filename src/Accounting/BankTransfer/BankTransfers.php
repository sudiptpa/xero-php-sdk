<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\BankTransfer;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

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
        $items = array_values(array_map(
            fn (array $bankTransfer): BankTransfer => $this->mapBankTransfer($bankTransfer),
            $payload['BankTransfers'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $bankTransferId): ?BankTransfer
    {
        $response = $this->client
            ->get('/api.xro/2.0/BankTransfers/' . $bankTransferId)
            ->send();

        $payload = $response->json();
        $bankTransfer = $payload['BankTransfers'][0] ?? null;

        return is_array($bankTransfer) ? $this->mapBankTransfer($bankTransfer) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapBankTransfer(array $payload): BankTransfer
    {
        return (new BankTransfer($this->client))
            ->setBankTransferID(isset($payload['BankTransferID']) ? (string) $payload['BankTransferID'] : null)
            ->setFromBankAccountID(
                isset($payload['FromBankAccount']['AccountID']) && is_string($payload['FromBankAccount']['AccountID'])
                    ? $payload['FromBankAccount']['AccountID']
                    : null
            )
            ->setToBankAccountID(
                isset($payload['ToBankAccount']['AccountID']) && is_string($payload['ToBankAccount']['AccountID'])
                    ? $payload['ToBankAccount']['AccountID']
                    : null
            )
            ->setAmount(isset($payload['Amount']) && is_numeric($payload['Amount']) ? $payload['Amount'] + 0 : null)
            ->setReference(isset($payload['Reference']) ? (string) $payload['Reference'] : null)
            ;
    }
}
