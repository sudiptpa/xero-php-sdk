# Auth

OAuth 2.0 setup, tenant selection, token refresh, and custom connections.

Steps:

1. Redirect the user to Xero
2. Exchange the code for a token
3. List available connections
4. Pick a tenant
5. Keep the token fresh

## Authorization flow

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
$connected = $connections->connectTenant($availableTenants[0]->getTenantId());

$xero = $connected->tenant();
```

Call `tenant()` to get a client scoped to that tenant. `getClient()` works too.

```php
$contacts = $xero->accounting()
    ->contacts()
    ->page(1)
    ->get();
```

## PKCE

Pass the verifier when exchanging the code:

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

Use `exchangeAndConnect()` when the tenant is already known. Use `exchange()` then `connections()` when the user still needs to choose.

## Refresh tokens

```php
$freshToken = $connections->refresh();

$accessToken = $freshToken->getAccessToken();
$refreshToken = $freshToken->getRefreshToken();
$accessTokenExpiresAt = $freshToken->getExpiresAt();
$refreshTokenExpiresAt = $freshToken->getRefreshTokenExpiresAt();
```

`InMemoryTokenRepository` is for tests only. Production apps should store tokens in a database or cache.

The token tracks two expiry times:

- access token expiry via `getExpiresAt()`
- refresh token expiry via `getRefreshTokenExpiresAt()`

## Custom connections

Custom connections use client credentials. There is no tenant discovery step.

```php
$client = $connections->customConnection([
    'finance.statements.read',
]);
```

Request only the scopes the integration actually needs.

## Tenant discovery

Tenant discovery calls `identity()->connections()` and does not send a tenant header. Make tenant-scoped API calls only after picking a tenant.

To disconnect a connection:

```php
$connections->disconnectTenant('tenant-id');
```

## Scopes

- User-consent flows need `openid`, `profile`, `email`, and `offline_access` plus the API scopes you use
- `accounting.contacts.read`: read contacts
- `accounting.contacts`: write contacts
- `accounting.transactions.read`: read invoices, payments, credit notes
- `accounting.transactions`: write transactions
- Keep scope lists small for payroll, files, assets, finance, and app-store flows
- Apps created on or after 2 March 2026 must use granular scopes
- Apps created before 2 March 2026 can start requesting granular scopes from April 2026
- All apps must migrate off broad scopes by September 2027
- Do not use broad scopes for new integrations when granular scopes are available
