# Xero PHP SDK

A fluent Xero SDK for PHP 8.2+ with no runtime dependencies.

## Status

The package already includes:

- domain-first architecture
- fluent client design
- zero runtime dependencies
- multi-tenant context handling
- transport abstraction
- typed models and write builders
- production-ready test and static-analysis coverage

## Installation

```bash
composer require sujip/xero-php-sdk
```

Requirements:

- PHP 8.2+
- `ext-json`
- `ext-curl` for the built-in native transport

## Quick Start

Most Xero integrations follow the same path:

1. build an authorization URL
2. exchange the callback code for a token
3. list available tenant connections
4. choose one tenant
5. make your first API call

This is the shortest useful path:

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

When Xero redirects back:

```php
$token = $manager->exchange($code);
$tenants = $manager->connections();

$connected = $manager->connectTenant($tenants[0]->tenantId);

$contacts = $connected->client
    ->accounting()
    ->contacts()
    ->page(1)
    ->get();
```

If you already know the tenant id, `exchangeAndConnect()` is the shorter path:

```php
$connected = $manager->exchangeAndConnect($code, 'tenant-id');
```

## API Style

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
use Sujip\Xero\Accounting\Invoice\Invoice;
use Sujip\Xero\Accounting\Invoice\LineItem;

$invoice = $xero->accounting()
    ->invoices()
    ->create()
    ->using(
        (new Invoice())
            ->setType('ACCREC')
            ->setStatus('DRAFT')
            ->setContactID('contact-id')
            ->setReference('PO-1001')
            ->addLineItem(
                (new LineItem())
                    ->setDescription('Consulting')
                    ->setQuantity(2)
                    ->setUnitAmount(150)
            )
    )
    ->save();
```

```php
use Sujip\Xero\Accounting\Payment\Payment;

$payment = $xero->accounting()
    ->payments()
    ->create()
    ->using(
        (new Payment())
            ->setInvoiceID('invoice-id')
            ->setAccountID('account-id')
            ->setDate('2026-03-25')
            ->setAmount(150)
            ->setReference('PAY-1001')
    )
    ->save();
```

```php
use Sujip\Xero\Accounting\Contact\Contact;

$updated = $xero->accounting()
    ->contacts()
    ->update('contact-id')
    ->using(
        (new Contact())
            ->setContactID('contact-id')
            ->setName('Acme Holdings Pty Ltd')
    )
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
$files = $xero->files()
    ->forObject('invoice-id')
    ->get();
```

```php
$assets = $xero->assets()
    ->status('registered')
    ->orderBy('AssetName')
    ->filterBy('MacBook')
    ->get();
```

```php
$project = $xero->projects()
    ->create()
    ->title('Website rebuild')
    ->contact('contact-id')
    ->estimateMinutes(600)
    ->save();
```

```php
$entries = $xero->projects()
    ->timeEntries('project-id')
    ->user('user-id')
    ->task('task-id')
    ->states('INPROGRESS')
    ->get();
```

```php
$employees = $xero->payroll()
    ->au()
    ->employees()
    ->page(1)
    ->get();
```

```php
$leave = $xero->payroll()
    ->au()
    ->leaveApplications()
    ->create()
    ->employee('employee-id')
    ->leaveType('leave-type-id')
    ->title('Annual Leave')
    ->startDate('2026-04-01')
    ->endDate('2026-04-02')
    ->save();
```

```php
$timesheet = $xero->payroll()
    ->nz()
    ->timesheets()
    ->create()
    ->employee('employee-id')
    ->startDate('2026-03-23')
    ->endDate('2026-03-29')
    ->status('DRAFT')
    ->save();
```

```php
$balances = $xero->payroll()
    ->uk()
    ->employees()
    ->find('employee-id')
    ?->leaveBalances();
```

```php
$balanceSheet = $xero->finance()
    ->statements()
    ->balanceSheet(new DateTimeImmutable('2026-03-31'));
```

```php
$subscription = $xero->appStore()
    ->subscriptions()
    ->find('subscription-id');
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

The package is meant to feel clean in real application code:

- fluent API instead of generated client sprawl
- domain-first structure that is easy to maintain
- typed models for reads and focused builders for writes
- framework-neutral integration points
- strong testing culture and coverage discipline
- excellent documentation and migration guidance
- community-friendly open source foundations

## Granular Scopes

Xero's scope model is changing, so the docs need to stay clear about what each integration actually needs.

- Apps created on or after 2 March 2026 use granular scopes
- Apps created before 2 March 2026 can begin requesting granular scopes from April 2026
- Existing apps have until September 2027 to complete migration from broad scopes

Practical rule:

- ask only for the scopes the integration actually uses
- use granular scopes for new apps
- keep broad scopes only where an older app still needs migration time
- Calling an endpoint without the required granular scope can return a `401` with insufficient scope details

The package already carries scope metadata on implemented resources. The goal is straightforward: if an endpoint needs a scope, it should be obvious in both the code and the docs.

In practice:

- read-only flows should request read scopes where Xero provides them
- create, update, delete, and action endpoints should request the matching write scopes
- new apps should be designed around granular scopes first

## Identity And Tenants

Xero has two different ideas that are easy to blur together:

- a user connection
- a tenant-scoped API request

The package treats them separately.

Use `identity()->connections()` to discover which tenants a token can access. Use `tenant(...)` when you make tenant-scoped API calls such as Accounting, Files, Projects, Assets, Finance, and Payroll requests.

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

PKCE and custom connections are first-class too. See [Auth](docs/auth.md) for those flows.

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
- file delete helper
- file upload builder
- file association helpers
- object-side file association lookup
- folders query, create, and delete builders
- folder inbox helper
- assets query builder
- assets search and pagination helpers
- asset create builder
- asset types query and create builders
- asset settings helper
- projects query, create, and update builders
- project users query builder
- project task query, create, update, and delete helpers
- project time entry query, create, update, and delete helpers
- payroll AU employees query builder
- payroll AU leave applications query, create, update, approve, and reject helpers
- payroll AU pay items query builder
- payroll AU pay runs query, create, and update builders
- payroll AU timesheets query, create, and update builders
- payroll AU settings helper
- payroll NZ employees query, create, and update builders
- payroll NZ leave types query builder
- payroll NZ pay run calendars query builder
- payroll NZ pay runs query and create builders
- payroll NZ timesheets query, create, update, approve, revert, and delete helpers
- payroll NZ settings helper
- payroll UK employees query, create, update, and leave balance helpers
- payroll UK pay run calendars query builder
- payroll UK pay runs query and create builders
- payroll UK timesheets query, create, update, approve, and revert helpers
- finance accounting activities reader
- finance cash validation reader
- finance financial statements readers for balance sheet, cashflow, profit and loss, trial balance, contact expenses, and contact revenue
- app store subscription lookup
- app store usage record listing, creation, and update helpers
- shared pagination primitives
- fake transport for fast test coverage

## Documentation

- [Architecture](docs/architecture.md)
- [Auth](docs/auth.md)
- [Accounting](docs/accounting.md)
- [Accounting Coverage](docs/accounting-coverage.md)
- [Files](docs/files.md)
- [Assets](docs/assets.md)
- [Projects](docs/projects.md)
- [Payroll AU](docs/payroll-au.md)
- [Payroll NZ](docs/payroll-nz.md)
- [Payroll UK](docs/payroll-uk.md)
- [Finance](docs/finance.md)
- [App Store](docs/app-store.md)
- [Webhooks](docs/webhooks.md)
- [Package Status](docs/package-status.md)
- [Implementation Status](docs/implementation-status.md) — includes the Xero docs overview table
- [Roadmap](docs/roadmap.md)
- [Release Checklist](docs/release-checklist.md)

## Contributing

If you want to help, start with:

- [Contributing](CONTRIBUTING.md)
- [Changelog](CHANGELOG.md)
- [Release Checklist](docs/release-checklist.md)
