# Architecture

## Public API

```php
$xero->accounting()->contacts()->where(...)->page(1)->get();
$xero->accounting()->invoices()->create()->using(new Invoice())->save();
$xero->payroll()->au()->employees()->get();
```

## Layers

- `Http` — request, response, transport, test doubles
- `Auth` — token handling, auth flows, connection strategies
- `Accounting`, `Files`, `Projects`, `Assets`, `Finance`, `AppStore`
- `Payroll\AU`, `Payroll\NZ`, `Payroll\UK`
- `Support` — collections, helpers, and shared value objects
- `Webhooks` — signature verification and event mapping

## Package shape

- domain first: `Accounting`, `Files`, `Projects`, `Payroll`
- country second: `Payroll\AU`, `Payroll\NZ`, `Payroll\UK`
- shared regional infrastructure lives under `Payroll\Shared`

## Design rules

- root client owns auth and tenant context
- resource flows stay fluent and small
- endpoint-specific flows compose a shared HTTP layer
- pagination and common query features live in shared support concerns
- request objects are typed and explicit
- tests validate request construction before broad endpoint rollout
- public APIs read naturally in application code

## Models

- Xero field names are the source of truth at the API boundary
- PHP models use the package's method naming style
- rich models are the public face of the package; arrays stay at the HTTP boundary

Examples:

- `ContactID` → `getContactID()` and `setContactID(...)`
- `EmailAddress` → `getEmailAddress()` and `setEmailAddress(...)`
- `LineItems` → `getLineItems()`, `setLineItems(...)`, and `addLineItem(...)`

Rules:

- getters follow the Xero field name in PHP method form
- setters use the same field name with a `set` prefix
- nested objects follow Xero naming
- collections keep the Xero plural names
- append methods (`addLineItem(...)`) are preferred for list-style fields

## Boundaries

- response JSON is decoded once at the HTTP boundary
- request and response mapping stays inside the SDK
- public models do not expose raw array access as the normal path

## Granular scopes

- Apps created on or after 2 March 2026 use granular scopes by default
- Apps created before 2 March 2026 can request granular scopes from April 2026
- All apps must migrate off broad scopes by September 2027
- A missing granular scope returns a `401` insufficient-scope response

## Tenant handling

- `identity()->connections()` works without a tenant header
- Accounting, Files, Projects, Assets, and Payroll requests send the tenant header when a tenant is set
- tenant discovery is part of the normal auth flow

## Webhooks

- verify the `x-xero-signature` header
- parse the payload into typed events
- fail loudly on invalid signatures
