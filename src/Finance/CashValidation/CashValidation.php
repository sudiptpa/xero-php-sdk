<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class CashValidation implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['finance.cashvalidation.read']
        );
    }

    public function get(DateTimeInterface $balanceDate): CashValidationResult
    {
        $payload = $this->client
            ->get('/finance.xro/1.0/CashValidation')
            ->withQuery([
                'balanceDate' => $balanceDate->format('Y-m-d'),
            ])
            ->send()
            ->json();

        $result = $payload['CashValidation'] ?? $payload;

        if (! is_array($result)) {
            return new CashValidationResult();
        }

        return (new CashValidationResult())
            ->setStatus(isset($result['Status']) ? (string) $result['Status'] : null)
            ->setBalance(isset($result['Balance']) ? (float) $result['Balance'] : null)
            ->setCurrency(isset($result['Currency']) ? (string) $result['Currency'] : null);
    }
}
