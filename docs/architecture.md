# Architecture

## Goals

- PHP 8.2+
- zero runtime dependencies
- fluent, Laravel-inspired API
- one package for all supported Xero surfaces
- strongly typed building blocks
- docs-first endpoint coverage
- production-grade package ergonomics
- clear contributor-friendly structure

## Public API Style

The SDK should feel like a Xero-native request DSL:

```php
$xero->accounting()->contacts()->where(...)->page(1)->get();
$xero->accounting()->invoices()->create()->draft()->lineItem(...)->save();
$xero->payroll()->au()->employees()->get();
```

The package should not feel like a generated SDK. It should feel like a carefully-designed framework integration.

## Internal Layers

- `Http`: request, response, transport, test doubles
- `Auth`: token handling, auth flows, connection strategies
- `Accounting`, `Files`, `Projects`, `Assets`, `Finance`, `AppStore`
- `Payroll\\AU`, `Payroll\\NZ`, `Payroll\\UK`
- `Support`: collections, hydration, helpers, value objects
- `Webhooks`: signature verification and event mapping

## Domain Pattern

The package is organized by Xero capability first, then by regional variation where needed.

- domain first: `Accounting`, `Files`, `Projects`, `Payroll`
- country second: `Payroll\\AU`, `Payroll\\NZ`, `Payroll\\UK`
- shared regional infrastructure lives under `Payroll\\Shared`

This keeps the architecture distinct from older SDK patterns while still making country-specific APIs explicit and easy to discover.

## Architectural Rules

- root client owns auth and tenant context
- resource builders stay fluent and small
- endpoint-specific builders compose a shared HTTP layer
- pagination and common query features should be implemented as shared support concerns
- payload builders are typed and immutable where practical
- tests validate request construction before broad endpoint rollout
- public APIs should read naturally in application code

## Immediate Production Priorities

- native transport with exception mapping
- OAuth2 token lifecycle support
- shared request modifiers for current Xero query patterns
- high-quality vertical coverage before broad endpoint expansion

## Granular Scopes

Xero's granular scopes are now an architectural requirement, not just a docs detail.

- Apps created on or after 2 March 2026 use granular scopes by default
- Apps created before 2 March 2026 can request granular scopes starting in April 2026
- Existing apps have until September 2027 to migrate from broad scopes
- Missing granular scopes can result in a `401` insufficient-scope response and should map to a dedicated SDK exception path later

The SDK should eventually include:

- endpoint-to-scope metadata
- auth helpers that make requested scopes explicit
- permission upgrade guidance in docs
- error handling that can surface "update permissions" style recovery paths

## Current Direction

The SDK now has the basic pieces needed for a serious integration:

- a native transport for real requests
- a small OAuth client for code exchange, refresh, and client credentials
- an auth lifecycle helper for stored tokens and tenant selection
- typed exceptions for common Xero failure modes
- tenant discovery through identity connections
- webhook verification and payload parsing
- scope metadata on the first Accounting resources
- fluent query and create builders for contacts, invoices, payments, and accounts
- real Files coverage for uploads, folders, inbox, and associations
- real Assets coverage for assets, asset types, and settings
- real Projects coverage for projects, users, tasks, and time entries
- real Payroll AU coverage for employees, leave applications, pay items, pay runs, timesheets, and settings
- real Payroll NZ coverage for employees, leave types, pay run calendars, pay runs, timesheets, and settings
- real Payroll UK coverage for employees, leave balances, pay run calendars, pay runs, and timesheets
- real Finance coverage for accounting activities, cash validation, and financial statements
- real App Store coverage for subscriptions and usage records

That still leaves a lot to build, but the package is now moving on reusable rails instead of one-off endpoint classes.

## Tenant Handling

Identity connections are not the same thing as tenant-scoped API calls.

- `identity()->connections()` should work without sending a tenant header
- Accounting, Files, Projects, Assets, and Payroll requests should send the tenant header when a tenant is set
- tenant discovery should be part of the normal auth story in the docs

This separation matters because it shapes how apps connect the first time and how they recover when a tenant connection changes.

## Webhooks

Webhook support should feel boring and reliable:

- verify the `x-xero-signature` header
- parse the payload into typed events
- fail loudly on invalid signatures

That is enough for the first version. Framework adapters and richer event helpers can come later.
