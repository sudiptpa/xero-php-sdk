# Auth

The package should make the normal Xero connection flow feel straightforward:

1. send the user to Xero
2. exchange the code for a token
3. list available connections
4. choose a tenant
5. keep the token fresh

## Basic Flow

```php
use Sujip\Xero\Auth\ConnectionManager;
use Sujip\Xero\Auth\InMemoryTokenRepository;
use Sujip\Xero\Xero;

$oauth = Xero::oauth2(
    clientId: 'client-id',
    clientSecret: 'client-secret',
    redirectUri: 'https://example.com/xero/callback',
);

$connections = new ConnectionManager(
    $oauth,
    new InMemoryTokenRepository(),
);

$url = $connections->authorizationUrl(
    scopes: ['openid', 'offline_access', 'accounting.contacts'],
    state: 'csrf-token',
);
```

After Xero redirects back with a code:

```php
$token = $connections->exchange($code);

$availableTenants = $connections->connections();
$connected = $connections->connectTenant($availableTenants[0]->tenantId);

$xero = $connected->client;
```

## Refreshing Tokens

```php
$freshToken = $connections->refresh();
```

The repository is intentionally simple right now. In a real app, store tokens in your database rather than memory.

## Tenant Discovery

Tenant discovery uses `identity()->connections()` and does not send a tenant header.

Tenant-scoped calls, like Accounting or Payroll requests, should only happen after you choose a tenant.
