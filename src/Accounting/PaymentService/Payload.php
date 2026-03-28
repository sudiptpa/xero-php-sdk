<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PaymentService;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['PaymentServiceName'] = $name;

        return $clone;
    }

    public function url(string $url): self
    {
        $clone = clone $this;
        $clone->payload['PaymentServiceUrl'] = $url;

        return $clone;
    }

    public function payNowText(string $payNowText): self
    {
        $clone = clone $this;
        $clone->payload['PayNowText'] = $payNowText;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): PaymentService
    {
        $response = $this->client
            ->post('/api.xro/2.0/PaymentServices')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['PaymentServices' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $paymentService = $payload['PaymentServices'][0] ?? [];

        return (new PaymentServices($this->client))
            ->mapPaymentService(is_array($paymentService) ? $paymentService : []);
    }
}
