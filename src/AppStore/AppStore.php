<?php

declare(strict_types=1);

namespace Sujip\Xero\AppStore;

use Sujip\Xero\Client;
use Sujip\Xero\AppStore\Subscription\Subscriptions;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ScopeRequirements;

final readonly class AppStore implements DefinesScopes
{
    public function __construct(
        private Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: [],
            granular: ['marketplace.billing']
        );
    }

    public function subscriptions(): Subscriptions
    {
        return new Subscriptions($this->client);
    }
}
