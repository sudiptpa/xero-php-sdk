# Identity reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Identity\Connection](#identityconnection)
- [Identity\Connections](#identityconnections)
- [Identity\Identity](#identityidentity)

## Identity\Connection

[Source](../../src/Identity/Connection.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `setId()` |
| `authEventId` | string or null | `setAuthEventId()` |
| `tenantId` | string or null | `setTenantId()` |
| `tenantName` | string or null | `setTenantName()` |
| `tenantType` | string or null | `setTenantType()` |
| `createdDateUtc` | string or null | `setCreatedDateUtc()` |
| `updatedDateUtc` | string or null | `setUpdatedDateUtc()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL, ?string $id = NULL, ?string $authEventId = NULL, ?string $tenantId = NULL, ?string $tenantName = NULL, ?string $tenantType = NULL, ?string $createdDateUtc = NULL, ?string $updatedDateUtc = NULL)`](../../src/Identity/Connection.php#L14)
- [`getId(): ?string`](../../src/Identity/Connection.php#L26)
- [`setId(?string $id): Sujip\Xero\Identity\Connection`](../../src/Identity/Connection.php#L30)
- [`getAuthEventId(): ?string`](../../src/Identity/Connection.php#L35)
- [`setAuthEventId(?string $authEventId): Sujip\Xero\Identity\Connection`](../../src/Identity/Connection.php#L39)
- [`getTenantId(): ?string`](../../src/Identity/Connection.php#L44)
- [`setTenantId(?string $tenantId): Sujip\Xero\Identity\Connection`](../../src/Identity/Connection.php#L48)
- [`getTenantName(): ?string`](../../src/Identity/Connection.php#L53)
- [`setTenantName(?string $tenantName): Sujip\Xero\Identity\Connection`](../../src/Identity/Connection.php#L57)
- [`getTenantType(): ?string`](../../src/Identity/Connection.php#L62)
- [`setTenantType(?string $tenantType): Sujip\Xero\Identity\Connection`](../../src/Identity/Connection.php#L66)
- [`getCreatedDateUtc(): ?string`](../../src/Identity/Connection.php#L71)
- [`setCreatedDateUtc(?string $createdDateUtc): Sujip\Xero\Identity\Connection`](../../src/Identity/Connection.php#L75)
- [`getUpdatedDateUtc(): ?string`](../../src/Identity/Connection.php#L80)
- [`setUpdatedDateUtc(?string $updatedDateUtc): Sujip\Xero\Identity\Connection`](../../src/Identity/Connection.php#L84)
- [`disconnect(): bool`](../../src/Identity/Connection.php#L106)

## Identity\Connections

[Source](../../src/Identity/Connections.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Identity/Connections.php#L13)
- [`get(?string $authEventId = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Identity/Connections.php#L21)
- [`findByTenant(string $tenantId): ?\Sujip\Xero\Identity\Connection`](../../src/Identity/Connections.php#L42)
- [`disconnect(string $connectionId): bool`](../../src/Identity/Connections.php#L53)
- [`mapConnection(array $connection): Sujip\Xero\Identity\Connection`](../../src/Identity/Connections.php#L66)

## Identity\Identity

[Source](../../src/Identity/Identity.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Identity/Identity.php#L11)
- [`connections(): Sujip\Xero\Identity\Connections`](../../src/Identity/Identity.php#L16)
