<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Receipt;

use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\User\User;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private Receipt $receipt;

    public function __construct(
        private readonly Client $client
    ) {
        $this->receipt = new Receipt($client);
    }

    public function id(string $receiptId): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->setReceiptID($receiptId);

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->setContact(
            (new Contact())->setContactID($contactId)
        );

        return $clone;
    }

    public function user(string $userId): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->setUser(
            (new User())->setUserID($userId)
        );

        return $clone;
    }

    public function lineItem(string $description, int|float $quantity, int|float $unitAmount, ?string $accountCode = null): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->addLineItem(
            (new LineItem())
                ->setDescription($description)
                ->setQuantity($quantity)
                ->setUnitAmount($unitAmount)
                ->setAccountCode($accountCode)
        );

        return $clone;
    }

    public function date(string $date): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->setDate($date);

        return $clone;
    }

    public function reference(string $reference): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->setReference($reference);

        return $clone;
    }

    public function lineAmountTypes(string $lineAmountTypes): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->setLineAmountTypes($lineAmountTypes);

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->receipt = clone $this->receipt;
        $clone->receipt->setStatus($status);

        return $clone;
    }

    public function using(Receipt $receipt): self
    {
        $clone = clone $this;
        $clone->receipt = clone $receipt;

        return $clone;
    }

    public function save(): Receipt
    {
        $receiptId = $this->receipt->getReceiptID();

        $response = $receiptId === null
            ? $this->client->put('/api.xro/2.0/Receipts')->withJson(['Receipts' => [$this->receipt->toRequest()]])
            : $this->client->post('/api.xro/2.0/Receipts/' . $receiptId)->withJson(['Receipts' => [$this->receipt->toRequest()]]);

        $payload = $response->send()->json();
        $receipt = Json::extractFirst($payload, 'Receipts') ?? [];

        return (new Receipts($this->client))->mapReceipt($receipt);
    }
}
