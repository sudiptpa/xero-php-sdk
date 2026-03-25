# Sujip Xero PHP SDK

A modern, fluent, dependency-free Xero SDK for PHP 8.2+ inspired by Laravel's HTTP client ergonomics.

## Status

This package is in active development. The initial foundation focuses on:

- domain-first architecture
- fluent client architecture
- zero runtime dependencies
- multi-tenant context handling
- transport abstraction
- elegant resource builders
- docs-first API coverage planning
- production-grade maintainability

## Design Direction

```php
use Sujip\Xero\Xero;

$xero = Xero::withAccessToken('token')
    ->tenant('tenant-id');

$contacts = $xero->accounting()
    ->contacts()
    ->where('Name.Contains(:name)', name: 'Acme')
    ->orderBy('Name')
    ->page(1)
    ->get();
```

```php
$page = $xero->accounting()
    ->contacts()
    ->paginate(page: 2);
```

```php
$invoice = $xero->accounting()
    ->invoices()
    ->create()
    ->draft()
    ->contact('contact-id')
    ->reference('PO-1001')
    ->lineItem('Consulting', quantity: 2, unitAmount: 150)
    ->save();
```

```php
$payment = $xero->accounting()
    ->payments()
    ->create()
    ->invoice('invoice-id')
    ->account('account-id')
    ->date('2026-03-25')
    ->amount(150)
    ->reference('PAY-1001')
    ->save();
```

```php
$updated = $xero->accounting()
    ->contacts()
    ->update('contact-id')
    ->name('Acme Holdings Pty Ltd')
    ->save();
```

```php
$attachment = $xero->accounting()
    ->invoices()
    ->attachments('invoice-id')
    ->upload('invoice.pdf', $pdfBinary)
    ->mimeType('application/pdf')
    ->includeOnline()
    ->save();
```

```php
$file = $xero->files()
    ->upload('contract.pdf', $binary)
    ->mimeType('application/pdf')
    ->toFolder('folder-id')
    ->save();
```

```php
$folder = $xero->files()
    ->folders()
    ->inbox();
```

```php
$asset = $xero->assets()
    ->create()
    ->name('MacBook Pro')
    ->number('FA-1001')
    ->status('draft')
    ->assetType('asset-type-id')
    ->save();
```

```php
$employees = $xero->payroll()
    ->au()
    ->employees()
    ->page(1)
    ->get();
```

```php
$connections = Xero::withAccessToken($token)
    ->identity()
    ->connections()
    ->get();
```

```php
$verifier = Xero::webhookVerifier($signingKey);

$verifier->assertValid($rawPayload, $signatureHeader);
$webhook = $verifier->parse($rawPayload);
```

## Why This Package

The goal is to build a genuinely production-grade Xero package that teams enjoy using and contributing to:

- elegant fluent API instead of generated client sprawl
- domain-first structure that is easy to maintain
- strong testing culture and coverage discipline
- excellent documentation and migration guidance
- community-friendly open source foundations

## Granular Scopes Note

Xero's scope model is changing, and this package needs to handle that cleanly.

- Apps created on or after 2 March 2026 use granular scopes
- Apps created before 2 March 2026 can begin requesting granular scopes from April 2026
- Existing apps have until September 2027 to complete migration from broad scopes
- Calling an endpoint without the required granular scope can return a `401` with insufficient scope details

The package now carries scope metadata on the first Accounting resources. The long-term goal is simple: every endpoint should make its required scopes obvious in the code and in the docs.

## Identity And Tenants

Xero has two different ideas that are easy to blur together:

- a user connection
- a tenant-scoped API request

The package treats them separately.

Use `identity()->connections()` to discover which tenants a token can access. Use `tenant(...)` when you are making tenant-scoped API calls such as Accounting, Files, Projects, and Payroll requests.

## Auth Flow

The package now has a small auth lifecycle helper for the normal Xero flow:

```php
use Sujip\Xero\Auth\InMemoryTokenRepository;
use Sujip\Xero\Xero;

$manager = Xero::oauth2(
    clientId: 'client-id',
    clientSecret: 'client-secret',
    redirectUri: 'https://example.com/xero/callback',
)->manager(new InMemoryTokenRepository());

$url = $manager->authorizationUrl(
    scopes: ['openid', 'offline_access', 'accounting.contacts'],
    state: 'csrf-token',
);
```

After callback:

```php
$manager->exchange($code);
$connected = $manager->connectTenant('tenant-id');

$xero = $connected->client;
```

## Current Foundation

- `Sujip\\Xero\\Xero` root entrypoint
- `Sujip\\Xero\\Client` fluent tenant-aware client
- lightweight HTTP transport contracts
- Laravel-style pending request pipeline
- native transport for production use
- OAuth2 token objects and authorization URL helpers
- OAuth2 client for code exchange and token refresh
- response error mapping for auth, validation, rate limits, and insufficient scope
- identity connections support for tenant discovery
- webhook signature verification and payload parsing
- auth lifecycle helper for connect, store, refresh, and tenant selection
- accounting contacts query builder
- accounting contact create builder
- accounting contact update builder
- accounting invoices draft builder
- accounting invoices query builder
- invoice attachment and history helpers
- accounting payments query and create builders
- accounting payment update builder
- accounting accounts query and create builders
- accounting account update builder
- files query builder
- file content download helper
- file upload builder
- file association helpers
- folders query and create builders
- folder inbox helper
- assets query builder
- asset create builder
- asset types query and create builders
- asset settings helper
- payroll AU employees query builder
- shared pagination primitives
- fake transport for fast test coverage

## Documentation

- [Architecture](docs/architecture.md)
- [Auth](docs/auth.md)
- [Accounting](docs/accounting.md)
- [Accounting Parity](docs/accounting-parity.md)
- [Files](docs/files.md)
- [Assets](docs/assets.md)
- [Coverage Map](docs/coverage-map.md)
- [Roadmap](docs/roadmap.md)
