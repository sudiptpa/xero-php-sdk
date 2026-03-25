<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $purchaseOrderId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $purchaseOrderId): self
    {
        $clone = clone $this;
        $clone->purchaseOrderId = $purchaseOrderId;

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->payload['Contact'] = ['ContactID' => $contactId];

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->payload['Reference'] = $reference;

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $clone = clone $this;
        $clone->payload['LineItems'] ??= [];
        $clone->payload['LineItems'][] = [
            'Description' => $description,
            'Quantity' => $quantity,
            'UnitAmount' => $unitAmount,
        ];

        return $clone;
    }

    public function save(): PurchaseOrder
    {
        if ($this->purchaseOrderId !== null) {
            $this->payload['PurchaseOrderID'] = $this->purchaseOrderId;
        }

        $response = $this->client
            ->post('/api.xro/2.0/PurchaseOrders')
            ->withJson(['PurchaseOrders' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $purchaseOrder = $payload['PurchaseOrders'][0] ?? [];

        return PurchaseOrder::fromArray(is_array($purchaseOrder) ? $purchaseOrder : [], $this->client);
    }
}
