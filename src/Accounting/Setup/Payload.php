<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Setup;

use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    private ?int $conversionMonth = null;

    private ?int $conversionYear = null;

    /**
     * @var list<array<string, mixed>>
     */
    private array $conversionBalances = [];

    /**
     * @var list<Account>
     */
    private array $accounts = [];

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function conversionDate(int $month, int $year): self
    {
        $clone = clone $this;
        $clone->conversionMonth = $month;
        $clone->conversionYear = $year;

        return $clone;
    }

    public function conversionBalance(string $accountCode, float $balance): self
    {
        $clone = clone $this;
        $clone->conversionBalances[] = [
            'AccountCode' => $accountCode,
            'Balance' => $balance,
        ];

        return $clone;
    }

    public function account(Account $account): self
    {
        $clone = clone $this;
        $clone->accounts[] = $account;

        return $clone;
    }

    public function idempotencyKey(string $idempotencyKey): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $idempotencyKey;

        return $clone;
    }

    public function save(): ImportSummary
    {
        $conversionDate = array_filter([
            'Month' => $this->conversionMonth,
            'Year' => $this->conversionYear,
        ], static fn (mixed $value): bool => $value !== null);

        $payload = $this->client
            ->post('/api.xro/2.0/Setup')
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson([
                'ConversionDate' => $conversionDate === [] ? new \stdClass() : $conversionDate,
                'ConversionBalances' => $this->conversionBalances,
                'Accounts' => array_map(
                    static fn (Account $account): array => $account->toRequest(),
                    $this->accounts
                ),
            ])
            ->send()
            ->json();

        $summary = Json::extractObject($payload, 'ImportSummary');

        return new ImportSummary(
            Json::extractObject($summary, 'Accounts'),
            Json::extractObject($summary, 'Organisation'),
            $summary
        );
    }
}
