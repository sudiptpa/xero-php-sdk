# Xero PHP SDK

[![PHP 8.2-8.5](https://img.shields.io/badge/PHP-8.2--8.5-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Tests](https://github.com/sudiptpa/xero-php-sdk/actions/workflows/ci.yml/badge.svg)](https://github.com/sudiptpa/xero-php-sdk/actions/workflows/ci.yml)
[![Latest Version](https://img.shields.io/packagist/v/sudiptpa/xero-php-sdk.svg)](https://packagist.org/packages/sudiptpa/xero-php-sdk)
[![Total Downloads](https://img.shields.io/packagist/dt/sudiptpa/xero-php-sdk.svg)](https://packagist.org/packages/sudiptpa/xero-php-sdk)
[![Release](https://img.shields.io/github/v/release/sudiptpa/xero-php-sdk)](https://github.com/sudiptpa/xero-php-sdk/releases)
[![Framework Agnostic](https://img.shields.io/badge/framework-agnostic-111827)](https://github.com/sudiptpa/xero-php-sdk)
[![License: MIT](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

---

[![Sponsor](https://img.shields.io/badge/Sponsor-GitHub%20Sponsors-ea4aaa?logo=githubsponsors&logoColor=white)](https://github.com/sponsors/sudiptpa)

If this package has been useful to you, GitHub Sponsors is a simple way to support ongoing maintenance, improvements, and future releases.

A fluent, framework-agnostic Xero SDK for PHP 8.2 to 8.5 with rich models, a fluent API, and no runtime dependencies.

- Rich models for reads and writes
- Fluent request flows across Xero families
- Aligned to the official Xero docs

## Why We Built It

- Build Xero integrations with rich models instead of raw payload arrays.
- Use one consistent API across Accounting, Files, Assets, Projects, Payroll, Finance, App Store, Identity, and Webhooks.
- Keep integration code readable in plain PHP or inside any framework.

This package is built for developers who want a modern Xero PHP SDK with a clear API for accounting, payroll, OAuth2, files, webhooks, and tenant-aware integrations.

## Installation

```bash
composer require sudiptpa/xero-php-sdk
```

Runtime Notes:

- PHP 8.2 to 8.5
- `ext-json` for JSON request and response handling
- `ext-curl` for the built-in native transport

If `ext-curl` is installed, `Xero::withAccessToken(...)` uses the built-in native transport by default.

If `ext-curl` is not installed, requests throw a transport exception when sent. In that case, supply your own transport such as a Guzzle-based transport.

## Custom Transport

If you want to use a custom transport, pass it explicitly.

### Guzzle Example

```php
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use Sujip\Xero\Exceptions\TransportException;
use Sujip\Xero\Http\Request;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Http\Transport;
use Sujip\Xero\Xero;

final class GuzzleTransport implements Transport
{
    public function __construct(
        private readonly GuzzleClient $client = new GuzzleClient()
    ) {
    }

    public function send(Request $request): Response
    {
        try {
            $response = $this->client->request($request->method, $request->url(), [
                'headers' => $request->headers,
                'json' => $request->json,
                'body' => $request->body,
            ]);
        } catch (GuzzleException $exception) {
            throw new TransportException($exception->getMessage(), previous: $exception);
        }

        return new Response(
            $response->getStatusCode(),
            array_map(
                static fn (array $values): string => $values[0] ?? '',
                $response->getHeaders()
            ),
            (string) $response->getBody(),
        );
    }
}

$xero = Xero::withAccessToken('token', new GuzzleTransport())
    ->tenant('tenant-id');
```

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

$contacts = $connected->tenant()
    ->accounting()
    ->contacts()
    ->page(1)
    ->get();
```

Use `tenant()` for the fluent tenant-scoped path. `getClient()` is also available if you prefer a more explicit accessor.

If you already know the tenant id, `exchangeAndConnect()` is the shorter path:

```php
$connected = $manager->exchangeAndConnect($code, 'tenant-id');
```

## Usage

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
use Sujip\Xero\Accounting\Contact\Contact;
use Sujip\Xero\Accounting\Invoice\LineItem;

$invoice = $xero->accounting()
    ->invoices()
    ->create()
    ->using(
        (new Invoice())
            ->setType('ACCREC')
            ->setStatus('DRAFT')
            ->setContact(
                (new Contact())
                    ->setContactID('contact-id')
            )
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
use Sujip\Xero\Accounting\Account\Account;
use Sujip\Xero\Accounting\Payment\Payment;

$payment = $xero->accounting()
    ->payments()
    ->create()
    ->using(
        (new Payment())
            ->setInvoiceID('invoice-id')
            ->setAccount(
                (new Account())
                    ->setAccountID('account-id')
            )
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

$fileName = $file->getName();
```

```php
$folder = $xero->files()
    ->folders()
    ->inbox();

$isInbox = $folder?->getIsInbox();
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

$assetName = $assets->first()?->getAssetName();
```

```php
$project = $xero->projects()
    ->create()
    ->title('Website rebuild')
    ->contact('contact-id')
    ->estimateMinutes(600)
    ->save();

$projectId = $project->getProjectID();
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

## Granular Scopes

- Apps created on or after 2 March 2026 use granular scopes
- Apps created before 2 March 2026 can begin requesting granular scopes from April 2026
- Existing apps have until September 2027 to complete migration from broad scopes

- Ask only for the scopes the integration actually uses.
- Prefer `.read` scopes for read-only jobs.
- Expect `401` insufficient-scope responses if an app is missing a required scope.

## Identity And Tenants

Use `identity()->connections()` to discover which tenants a token can access. Use `tenant(...)` when you make tenant-scoped API calls such as Accounting, Files, Projects, Assets, Finance, and Payroll requests.

## Auth Flow

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

$xero = $connected->tenant();
```

See [Auth](docs/auth.md) for PKCE, refresh, tenant selection, and custom connection flows.

## Supported APIs

- Accounting
- Files
- Assets
- Projects
- Payroll AU
- Payroll NZ
- Payroll UK
- Finance
- App Store
- Identity
- Webhooks

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

## Contributing

If you want to help, start with:

- [Contributing](CONTRIBUTING.md)
- [Changelog](CHANGELOG.md)
