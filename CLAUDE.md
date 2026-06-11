# xero-php-sdk — Project Context for Claude

## What This Package Is

`sudiptpa/xero-php-sdk` is a fluent, **framework-agnostic** Xero PHP SDK. It wraps the Xero API (Accounting, Payroll AU/NZ/UK, Files, Assets, Projects, Finance, AppStore, Identity, Webhooks) in a clean, type-safe PHP 8.2+ object graph. It has **no runtime dependencies** — no Laravel, no Guzzle. It runs anywhere PHP runs.

## Entry Points

```php
// Standard usage — access token from your OAuth2 flow
$client = Xero::withAccessToken($token)->tenant($tenantId);

// From a stored Token object
$client = Xero::withToken($token)->tenant($tenantId);

// OAuth2 helpers
$url  = Xero::authorizationUrl($clientId, $redirectUri, $scopes, $state);
$pkce = Xero::pkce();          // code verifier + challenge
$oauth = Xero::oauth2($clientId, $secret, $redirectUri);

// Webhook signature verification
$verifier = Xero::webhookVerifier($signingKey);
```

## SDK Surface

| API Group | Class | Entry |
|---|---|---|
| Accounting | `Accounting` | `$client->accounting()` |
| Payroll (AU/NZ/UK) | `Payroll` | `$client->payroll()` |
| Files | `Files` | `$client->files()` |
| Assets | `Assets` | `$client->assets()` |
| Projects | `Projects` | `$client->projects()` |
| Finance | `Finance` | `$client->finance()` |
| AppStore | `AppStore` | `$client->appStore()` |
| Identity | `Identity` | `$client->identity()` |
| Webhooks | `Webhooks` | `$client->webhooks()` |

## Architecture — Non-Negotiables

**Do not change these patterns. They are deliberate.**

- `Xero` is the static entry point. `Client` holds state and routes API calls.
- `Context` is a `readonly` value object — immutable, cloned for tenant/token changes.
- `PendingRequest` is immutable (clone-on-change). Every builder method returns a new instance.
- `Model` is the abstract base for all API response objects. It hydrates via `fill(array $payload)`.
- `Field` defines type + class for model hydration — never bypass it with magic properties.
- `Transport` is the only HTTP abstraction. `NativeTransport` = real cURL. `FakeTransport` = tests.
- `FakeTransport::push(Response $response)` queues responses — one per test assertion.
- All HTTP is synchronous — no async, no queueing (this is not a Laravel package).
- `declare(strict_types=1)` on every file.
- No external runtime dependencies. PHP extensions only (`curl`, `json`).

## Package Structure

```
src/
├── Xero.php                 # Static entry point (authorizationUrl, oauth2, webhookVerifier, pkce)
├── Client.php               # API router — accounting(), payroll(), files(), etc.
├── Context.php              # Readonly value object — accessToken, tenantId, baseUri
├── Accounting/              # Accounting API (131 files, full Xero Accounting coverage)
├── Payroll/                 # AU / NZ / UK payroll (88 files)
│   ├── Au/
│   ├── Nz/
│   └── Uk/
├── Files/                   # File management (11 files)
├── Assets/                  # Asset tracking (6 files)
├── Projects/                # Project management (8 files)
├── Finance/                 # Financial reporting (10 files)
├── Auth/                    # OAuth2, PKCE, Token, ConnectionManager, TokenRepository
├── Http/                    # Request, Response, Transport, NativeTransport, FakeTransport, PendingRequest
├── Exceptions/              # 8 typed exceptions (XeroException as base)
├── Support/                 # Model, Field, Json, PaginatedCollection, ResourceCollection, Concerns, Contracts
├── Identity/                # Identity API, Connection, Connections
├── AppStore/                # App store subscriptions
└── Webhooks/                # WebhookVerifier, WebhookPayload, WebhookEvent
tests/                       # 71 PHPUnit test files mirroring src/
```

## PHP Conventions

- PHP `^8.2 <8.6` — use union types, readonly properties, named arguments, match expressions
- `declare(strict_types=1)` on every file, no exceptions
- No `mixed` types where avoidable — be explicit
- `final` on concrete classes unless extensibility is intentional
- `readonly` classes/properties for value objects (Context, Token, etc.)
- PHPDoc blocks only where PHP type system cannot express the type (e.g., `array<string, Field>`, `list<string>`)
- Named constructor pattern (`Context::make(...)`, `Xero::withAccessToken(...)`) over bare `new`

## Testing Conventions

- Framework: PHPUnit 11.5 (not Pest — this is framework-agnostic)
- All tests `final class XxxTest extends TestCase`
- Test class mirrors src path: `src/Accounting/Contact/Contact.php` → `tests/Accounting/ContactsTest.php`
- HTTP: always use `FakeTransport` — never mock the `Client` or `Transport` with Mockery
- Queue multiple responses: `$transport->push($r1)->push($r2)`
- Assert `$transport->requests()` to verify correct URL/headers were sent
- Test method names: `test_it_does_something_specific()`
- No `@covers` annotations — code coverage is global

## Code Quality

- PHPStan: level `max`, covers `src/` and `tests/`
- Pint: `php` preset + `declare_strict_types: true`
- Coverage: 100% enforced (`--min=100`), pcov in CI
- CI matrix: PHP 8.2 / 8.3 / 8.4 / 8.5

## Local Dev

```bash
composer test        # Run tests
composer stan        # PHPStan max
composer coverage    # 100% coverage report (requires xdebug locally)
composer format      # Pint — auto-fix formatting
composer lint:check  # Pint — dry run (used in CI)
composer lint        # php -l syntax check
```

## Rules

**Never do these:**

- Do not add Laravel, Symfony, or any framework as a runtime dependency
- Do not add Guzzle or any HTTP client library as a runtime dependency
- Do not break the `Transport` abstraction — all HTTP goes through it
- Do not use `json_decode` without `JSON_THROW_ON_ERROR`
- Do not catch exceptions silently (`catch (\Throwable $e) {}` is banned)
- Do not use `array` type hints when `array<K, V>` or `list<T>` is expressible
- Do not add mutable state to `Context` — clone it
- Do not use `mixed` return types on public API methods
- Do not skip `declare(strict_types=1)`

**Security:**

- Webhook signature verification uses HMAC-SHA256 — never weaken or skip it
- OAuth2 state parameter must be validated by the consuming application
- PKCE code verifier must be stored server-side between authorization and token exchange
- Access tokens must never be logged
