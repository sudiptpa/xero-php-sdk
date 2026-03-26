# Auth

Xero auth is not hard, but it is easy to make messy in application code. The package tries to keep it boring.

1. send the user to Xero
2. exchange the code for a token
3. list available connections
4. choose a tenant
5. keep the token fresh

## Basic Flow

This is the normal user-consent flow for tenant-scoped apps.

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

At that point you can stop thinking about OAuth and start making normal API calls.

If you are using PKCE, pass the original verifier when you exchange the code:

```php
use Sujip\Xero\Auth\Pkce;

$verifier = Pkce::verifier();
$challenge = Pkce::challenge($verifier);

$url = $connections->authorizationUrl(
    scopes: ['openid', 'offline_access', 'accounting.contacts'],
    state: 'csrf-token',
    codeChallenge: $challenge,
);

$connected = $connections->exchangeAndConnect($code, 'tenant-id', $verifier);
```

## Refreshing Tokens

```php
$freshToken = $connections->refresh();
```

The in-memory repository is only for tests and small examples. Real apps should store tokens in the database.

## Custom Connections

Xero custom connections use the client credentials flow. They do not use tenant discovery in the usual way.

```php
$client = $connections->customConnection([
    'finance.statements.read',
]);
```

This is mainly for fixed server-to-server integrations. Keep the scope list small.

## Tenant Discovery

Tenant discovery uses `identity()->connections()` and does not send a tenant header.
Tenant-scoped calls should happen only after you choose a tenant.

## Scope Notes

- normal user-consent flows usually need `openid`, `profile`, `email`, and `offline_access` plus the API scopes you actually use
- new apps created on or after 2 March 2026 should expect granular scopes to be the normal path
- custom connections should request only the scopes that the fixed integration actually needs
