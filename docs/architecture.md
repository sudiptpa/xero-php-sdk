# Architecture

## Public API

```php
$xero->accounting()->contacts()->where(...)->page(1)->get();
$xero->accounting()->invoices()->create()->using(new Invoice())->save();
$xero->payroll()->au()->employees()->get();
```

## Internal Layers

- `Http`: request, response, transport, test doubles
- `Auth`: token handling, auth flows, connection strategies
- `Accounting`, `Files`, `Projects`, `Assets`, `Finance`, `AppStore`
- `Payroll\\AU`, `Payroll\\NZ`, `Payroll\\UK`
- `Support`: collections, helpers, and shared value objects
- `Webhooks`: signature verification and event mapping

## Package Shape

- domain first: `Accounting`, `Files`, `Projects`, `Payroll`
- country second: `Payroll\\AU`, `Payroll\\NZ`, `Payroll\\UK`
- shared regional infrastructure lives under `Payroll\\Shared`

## Architectural Rules

- root client owns auth and tenant context
- resource flows stay fluent and small
- endpoint-specific flows compose a shared HTTP layer
- pagination and common query features live in shared support concerns
- request objects are typed and explicit
- tests validate request construction before broad endpoint rollout
- public APIs read naturally in application code

## Model Standard

- official Xero request and response field names stay the source of truth at the API boundary
- PHP models keep the package's method naming style
- rich models are the public face of the package
- arrays stay at the HTTP boundary only

Examples:

- `ContactID` becomes `getContactID()` and `setContactID(...)`
- `EmailAddress` becomes `getEmailAddress()` and `setEmailAddress(...)`
- `LineItems` becomes `getLineItems()`, `setLineItems(...)`, and `addLineItem(...)`
- Projects payload keys like `contactId`, `taskId`, and `deadlineUtc` stay doc-accurate on the wire while mapping into the package's model methods

- getters should follow the Xero field name exactly in PHP method form
- setters should use the same field name with a `set...` prefix
- nested objects should also follow Xero naming
- collections should keep the Xero plural names
- append methods like `addLineItem(...)` are preferred for list-style fields

## Boundary Rules

- response JSON is decoded once at the HTTP boundary
- request and response mapping stays inside the SDK
- public models should not expose raw array access as the normal way to work

## Granular Scopes

- Apps created on or after 2 March 2026 use granular scopes by default
- Apps created before 2 March 2026 can request granular scopes starting in April 2026
- Existing apps have until September 2027 to migrate from broad scopes
- Missing granular scopes can result in a `401` insufficient-scope response and map to a dedicated SDK exception

## Tenant Handling

- `identity()->connections()` works without sending a tenant header
- Accounting, Files, Projects, Assets, and Payroll requests send the tenant header when a tenant is set
- tenant discovery is part of the normal auth flow in the docs

## Webhooks

- verify the `x-xero-signature` header
- parse the payload into typed events
- fail loudly on invalid signatures
