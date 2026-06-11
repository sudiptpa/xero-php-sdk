<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\PurchaseOrder;

use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private PurchaseOrder $purchaseOrder;

    public function __construct(
        private readonly Client $client
    ) {
        $this->purchaseOrder = new PurchaseOrder($client);
    }

    public function id(string $purchaseOrderId): self
    {
        $clone = clone $this;
        $clone->purchaseOrder = clone $this->purchaseOrder;
        $clone->purchaseOrder->setPurchaseOrderID($purchaseOrderId);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->purchaseOrder = clone $this->purchaseOrder;
        $clone->purchaseOrder->setContact(
            (new Contact())
                ->setContactID($contactId)
        );

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->purchaseOrder = clone $this->purchaseOrder;
        $clone->purchaseOrder->setReference($reference);

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount): self
    {
        $clone = clone $this;
        $clone->purchaseOrder = clone $this->purchaseOrder;
        $clone->purchaseOrder->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
        );

        return $clone;
    }

    public function using(PurchaseOrder $purchaseOrder): self
    {
        $clone = clone $this;
        $clone->purchaseOrder = clone $purchaseOrder;

        return $clone;
    }

    public function save(): PurchaseOrder
    {
        $response = $this->client
            ->post('/api.xro/2.0/PurchaseOrders')
            ->withJson(['PurchaseOrders' => [$this->purchaseOrder->toRequest()]])
            ->send();

        $payload = $response->json();
        $purchaseOrder = Json::extractFirst($payload, 'PurchaseOrders') ?? [];

        return (new PurchaseOrders($this->client))
            ->mapPurchaseOrder($purchaseOrder);
    }
}
