<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Accounting\Account\Accounts;
use Sujip\Xero\Accounting\History;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\BuildsQueries;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Concerns\InteractsWithBindings;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Payments implements PaginatesResults, DefinesScopes
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
            granular: ['accounting.payments.read', 'accounting.payments']
        );
    }

    public function where(string $expression, mixed ...$bindings): self
    {
        $clone = clone $this;
        $clone->query['where'] = $this->interpolateBindings($expression, $bindings);

        return $clone;
    }

    /**
     * @return ResourceCollection<Payment>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/Payments')
            ->withQuery(array_merge($this->queryParameters(), $this->paginationQuery()))
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $payment): Payment => $this->mapPayment($payment),
            $payload['Payments'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<Payment>
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

        return new PaginatedResult(
            $builder->get(),
            $builder->currentPage(),
            $builder->currentPerPage(),
            ['path' => '/api.xro/2.0/Payments']
        );
    }

    public function find(string $paymentId): ?Payment
    {
        $response = $this->client
            ->get('/api.xro/2.0/Payments/' . $paymentId)
            ->send();

        $payload = $response->json();
        $payment = $payload['Payments'][0] ?? null;

        return is_array($payment) ? $this->mapPayment($payment) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $paymentId): Payload
    {
        return (new Payload($this->client))->id($paymentId);
    }

    public function history(string $paymentId): History
    {
        return new History($this->client, '/api.xro/2.0/Payments/' . $paymentId . '/History');
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapPayment(array $payload): Payment
    {
        return (new Payment($this->client))
            ->setPaymentID(isset($payload['PaymentID']) ? (string) $payload['PaymentID'] : null)
            ->setAmount(isset($payload['Amount']) ? (float) $payload['Amount'] : null)
            ->setDate(isset($payload['Date']) ? (string) $payload['Date'] : null)
            ->setReference(isset($payload['Reference']) ? (string) $payload['Reference'] : null)
            ->setInvoiceID(
                isset($payload['Invoice']['InvoiceID']) && is_string($payload['Invoice']['InvoiceID'])
                    ? $payload['Invoice']['InvoiceID']
                    : null
            )
            ->setAccount(
                is_array($payload['Account'] ?? null)
                    ? (new Accounts($this->client))->mapAccount($payload['Account'])
                    : null
            );
    }
}
