<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PaymentService;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class PaymentServices implements DefinesScopes
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['paymentservices'],
            granular: []
        );
    }

    /**
     * @return ResourceCollection<PaymentService>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/api.xro/2.0/PaymentServices')
            ->send();

        $payload = $response->json();
        $items = array_values(array_map(
            fn (array $paymentService): PaymentService => $this->mapPaymentService($paymentService),
            $payload['PaymentServices'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    /**
     * @param array<string, mixed> $payload
     */
    public function mapPaymentService(array $payload): PaymentService
    {
        return (new PaymentService())->fill($payload);
    }
}
