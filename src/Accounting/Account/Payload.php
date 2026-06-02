<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Account;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private Account $account;

    public function __construct(
        private readonly Client $client
    ) {
        $this->account = new Account($client);
    }

    public function code(string $code): self
    {
        $clone = clone $this;
        $clone->account = clone $this->account;
        $clone->account->setCode($code);

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->account = clone $this->account;
        $clone->account->setName($name);

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->account = clone $this->account;
        $clone->account->setType($type);

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->account = clone $this->account;
        $clone->account->setDescription($description);

        return $clone;
    }

    public function id(string $accountId): self
    {
        $clone = clone $this;
        $clone->account = clone $this->account;
        $clone->account->setAccountID($accountId);

        return $clone;
    }

    public function using(Account $account): self
    {
        $clone = clone $this;
        $clone->account = clone $account;

        return $clone;
    }

    public function save(): Account
    {
        $path = '/api.xro/2.0/Accounts';

        if ($this->account->getAccountID() !== null) {
            $path .= '/' . $this->account->getAccountID();
        }

        $response = $this->client
            ->post($path)
            ->withJson([
                'Accounts' => [$this->account->toRequest()],
            ])
            ->send();

        $payload = $response->json();
        $account = Json::extractFirst($payload, 'Accounts') ?? [];

        return (new Accounts($this->client))
            ->mapAccount($account);
    }
}
