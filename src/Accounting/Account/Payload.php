<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Account;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $accountId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function code(string $code): self
    {
        $clone = clone $this;
        $clone->payload['Code'] = $code;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function type(string $type): self
    {
        $clone = clone $this;
        $clone->payload['Type'] = strtoupper($type);

        return $clone;
    }

    public function description(string $description): self
    {
        $clone = clone $this;
        $clone->payload['Description'] = $description;

        return $clone;
    }

    public function id(string $accountId): self
    {
        $clone = clone $this;
        $clone->accountId = $accountId;

        return $clone;
    }

    public function save(): Account
    {
        $path = '/api.xro/2.0/Accounts';

        if ($this->accountId !== null) {
            $path .= '/' . $this->accountId;
        }

        $response = $this->client
            ->post($path)
            ->withJson([
                'Accounts' => [$this->payload],
            ])
            ->send();

        $payload = $response->json();
        $account = $payload['Accounts'][0] ?? [];

        return Account::fromArray(is_array($account) ? $account : [], $this->client);
    }
}
