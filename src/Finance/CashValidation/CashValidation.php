<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\CashValidation;

use DateTimeInterface;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ResourceCollection;
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

    /**
     * @return ResourceCollection<CashValidationResult>
     */
    public function get(
        ?DateTimeInterface $balanceDate = null,
        ?DateTimeInterface $asAtSystemDate = null,
        ?DateTimeInterface $beginDate = null
    ): ResourceCollection {
        $query = [];

        if ($balanceDate !== null) {
            $query['balanceDate'] = $balanceDate->format('Y-m-d');
        }

        if ($asAtSystemDate !== null) {
            $query['asAtSystemDate'] = $asAtSystemDate->format('Y-m-d');
        }

        if ($beginDate !== null) {
            $query['beginDate'] = $beginDate->format('Y-m-d');
        }

        $payload = $this->client
            ->get('/finance.xro/1.0/CashValidation')
            ->withQuery($query)
            ->send()
            ->json();

        $items = array_map(
            fn (array $item): CashValidationResult => (new CashValidationResult())->fill($item),
            Json::extractRows($payload)
        );

        return new ResourceCollection($items);
    }
}
