<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ExpenseClaim;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class ExpenseClaims implements DefinesScopes
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
     * @return ResourceCollection<ExpenseClaim>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/ExpenseClaims')
            ->withQuery($this->queryParameters())
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $expenseClaim): ExpenseClaim => $this->mapExpenseClaim($expenseClaim),
            $payload['ExpenseClaims'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $expenseClaimId): ?ExpenseClaim
    {
        $response = $this->client
            ->get('/api.xro/2.0/ExpenseClaims/' . $expenseClaimId)
            ->send();

        $payload = $response->json();
        $expenseClaim = $payload['ExpenseClaims'][0] ?? null;

        return is_array($expenseClaim) ? $this->mapExpenseClaim($expenseClaim) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $expenseClaimId): Payload
    {
        return (new Payload($this->client))->id($expenseClaimId);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapExpenseClaim(array $payload): ExpenseClaim
    {
        $receiptIds = [];

        foreach (($payload['Receipts'] ?? []) as $receipt) {
            if (is_array($receipt) && isset($receipt['ReceiptID']) && is_string($receipt['ReceiptID'])) {
                $receiptIds[] = $receipt['ReceiptID'];
            }
        }

        return (new ExpenseClaim($this->client))
            ->setExpenseClaimID(isset($payload['ExpenseClaimID']) ? (string) $payload['ExpenseClaimID'] : null)
            ->setStatus(isset($payload['Status']) ? (string) $payload['Status'] : null)
            ->setEmployeeID(
                isset($payload['User']['UserID']) && is_string($payload['User']['UserID'])
                    ? $payload['User']['UserID']
                    : (isset($payload['Employee']['EmployeeID']) && is_string($payload['Employee']['EmployeeID'])
                        ? $payload['Employee']['EmployeeID']
                        : null)
            )
            ->setReceiptIDs($receiptIds)
            ->setTotal(isset($payload['Total']) && is_numeric($payload['Total']) ? $payload['Total'] + 0 : null)
            ;
    }
}
