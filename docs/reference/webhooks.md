# Webhooks reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Webhooks\WebhookEvent](#webhookswebhookevent)
- [Webhooks\WebhookPayload](#webhookswebhookpayload)
- [Webhooks\WebhookVerifier](#webhookswebhookverifier)
- [Webhooks\Webhooks](#webhookswebhooks)

## Webhooks\WebhookEvent

[Source](../../src/Webhooks/WebhookEvent.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `resourceUrl` | string or null | `setResourceUrl()` |
| `resourceId` | string or null | `setResourceId()` |
| `eventCategory` | string or null | `setEventCategory()` |
| `eventType` | string or null | `setEventType()` |
| `eventDateUtc` | string or null | `setEventDateUtc()` |
| `tenantId` | string or null | `setTenantId()` |
| `tenantType` | string or null | `setTenantType()` |
| `data` | array | `setData()` |

### Public methods

- [`__construct(?string $resourceUrl = NULL, ?string $resourceId = NULL, ?string $eventCategory = NULL, ?string $eventType = NULL, ?string $eventDateUtc = NULL, ?string $tenantId = NULL, ?string $tenantType = NULL, array $data = array (
), array $payload = array (
))`](../../src/Webhooks/WebhookEvent.php#L17)
- [`getResourceUrl(): ?string`](../../src/Webhooks/WebhookEvent.php#L30)
- [`setResourceUrl(?string $resourceUrl): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L34)
- [`getResourceId(): ?string`](../../src/Webhooks/WebhookEvent.php#L39)
- [`setResourceId(?string $resourceId): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L43)
- [`getEventCategory(): ?string`](../../src/Webhooks/WebhookEvent.php#L48)
- [`setEventCategory(?string $eventCategory): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L52)
- [`getEventType(): ?string`](../../src/Webhooks/WebhookEvent.php#L57)
- [`setEventType(?string $eventType): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L61)
- [`getEventDateUtc(): ?string`](../../src/Webhooks/WebhookEvent.php#L66)
- [`setEventDateUtc(?string $eventDateUtc): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L70)
- [`getTenantId(): ?string`](../../src/Webhooks/WebhookEvent.php#L75)
- [`setTenantId(?string $tenantId): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L79)
- [`getTenantType(): ?string`](../../src/Webhooks/WebhookEvent.php#L84)
- [`setTenantType(?string $tenantType): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L88)
- [`getData(): array`](../../src/Webhooks/WebhookEvent.php#L96)
- [`setData(array $data): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L103)
- [`getPayload(): array`](../../src/Webhooks/WebhookEvent.php#L111)
- [`setPayload(array $payload): Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookEvent.php#L118)
- [`fill(array $payload): static`](../../src/Webhooks/WebhookEvent.php#L141)
- [`is(string $category, ?string $type = NULL): bool`](../../src/Webhooks/WebhookEvent.php#L148)
- [`isCreate(): bool`](../../src/Webhooks/WebhookEvent.php#L161)
- [`isUpdate(): bool`](../../src/Webhooks/WebhookEvent.php#L166)
- [`isDelete(): bool`](../../src/Webhooks/WebhookEvent.php#L171)
- [`category(string $category): bool`](../../src/Webhooks/WebhookEvent.php#L176)
- [`type(string $type): bool`](../../src/Webhooks/WebhookEvent.php#L181)
- [`resource(string $resourceId): bool`](../../src/Webhooks/WebhookEvent.php#L186)
- [`occurredAt(): ?\DateTimeImmutable`](../../src/Webhooks/WebhookEvent.php#L191)
- [`resourceName(): ?string`](../../src/Webhooks/WebhookEvent.php#L200)
- [`path(): ?string`](../../src/Webhooks/WebhookEvent.php#L224)

## Webhooks\WebhookPayload

[Source](../../src/Webhooks/WebhookPayload.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `firstEventSequence` | int, float, or null | `setFirstEventSequence()` |
| `lastEventSequence` | int, float, or null | `setLastEventSequence()` |
| `entropy` | string or null | `setEntropy()` |

### Public methods

- [`__construct(int\|float\|null $firstEventSequence = NULL, int\|float\|null $lastEventSequence = NULL, ?string $entropy = NULL, ?\Sujip\Xero\Support\ResourceCollection $events = NULL)`](../../src/Webhooks/WebhookPayload.php#L22)
- [`getFirstEventSequence(): int\|float\|null`](../../src/Webhooks/WebhookPayload.php#L31)
- [`setFirstEventSequence(int\|float\|null $firstEventSequence): Sujip\Xero\Webhooks\WebhookPayload`](../../src/Webhooks/WebhookPayload.php#L35)
- [`getLastEventSequence(): int\|float\|null`](../../src/Webhooks/WebhookPayload.php#L40)
- [`setLastEventSequence(int\|float\|null $lastEventSequence): Sujip\Xero\Webhooks\WebhookPayload`](../../src/Webhooks/WebhookPayload.php#L44)
- [`getEntropy(): ?string`](../../src/Webhooks/WebhookPayload.php#L49)
- [`setEntropy(?string $entropy): Sujip\Xero\Webhooks\WebhookPayload`](../../src/Webhooks/WebhookPayload.php#L53)
- [`getEvents(): Sujip\Xero\Support\ResourceCollection`](../../src/Webhooks/WebhookPayload.php#L61)
- [`setEvents(\Sujip\Xero\Support\ResourceCollection $events): Sujip\Xero\Webhooks\WebhookPayload`](../../src/Webhooks/WebhookPayload.php#L68)
- [`fill(array $payload): static`](../../src/Webhooks/WebhookPayload.php#L86)
- [`hasEvents(): bool`](../../src/Webhooks/WebhookPayload.php#L98)
- [`isEmpty(): bool`](../../src/Webhooks/WebhookPayload.php#L103)
- [`count(): int`](../../src/Webhooks/WebhookPayload.php#L108)
- [`first(): ?\Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookPayload.php#L113)
- [`last(): ?\Sujip\Xero\Webhooks\WebhookEvent`](../../src/Webhooks/WebhookPayload.php#L118)
- [`categories(): array`](../../src/Webhooks/WebhookPayload.php#L135)
- [`eventTypes(): array`](../../src/Webhooks/WebhookPayload.php#L151)
- [`contains(string $category, ?string $type = NULL): bool`](../../src/Webhooks/WebhookPayload.php#L164)
- [`only(string $category, ?string $type = NULL): Sujip\Xero\Support\ResourceCollection`](../../src/Webhooks/WebhookPayload.php#L178)
- [`has(string $category, ?string $type = NULL): bool`](../../src/Webhooks/WebhookPayload.php#L191)
- [`resourceIds(): array`](../../src/Webhooks/WebhookPayload.php#L199)
- [`paths(): array`](../../src/Webhooks/WebhookPayload.php#L215)

## Webhooks\WebhookVerifier

[Source](../../src/Webhooks/WebhookVerifier.php)

### Public methods

- [`__construct(string $signingKey)`](../../src/Webhooks/WebhookVerifier.php#L12)
- [`signatureFor(string $payload): string`](../../src/Webhooks/WebhookVerifier.php#L17)
- [`verify(string $payload, ?string $signature): bool`](../../src/Webhooks/WebhookVerifier.php#L22)
- [`signatureFromHeaders(array $headers, string $header = 'x-xero-signature'): ?string`](../../src/Webhooks/WebhookVerifier.php#L34)
- [`verifyHeaders(string $payload, array $headers, string $header = 'x-xero-signature'): bool`](../../src/Webhooks/WebhookVerifier.php#L56)
- [`assertValid(string $payload, ?string $signature): void`](../../src/Webhooks/WebhookVerifier.php#L61)
- [`assertValidHeaders(string $payload, array $headers, string $header = 'x-xero-signature'): void`](../../src/Webhooks/WebhookVerifier.php#L71)
- [`parse(string $payload): Sujip\Xero\Webhooks\WebhookPayload`](../../src/Webhooks/WebhookVerifier.php#L76)
- [`verifyAndParse(string $payload, ?string $signature): Sujip\Xero\Webhooks\WebhookPayload`](../../src/Webhooks/WebhookVerifier.php#L84)
- [`verifyAndParseHeaders(string $payload, array $headers, string $header = 'x-xero-signature'): Sujip\Xero\Webhooks\WebhookPayload`](../../src/Webhooks/WebhookVerifier.php#L94)

## Webhooks\Webhooks

[Source](../../src/Webhooks/Webhooks.php)

### Public methods

- [`verifier(string $signingKey): Sujip\Xero\Webhooks\WebhookVerifier`](../../src/Webhooks/Webhooks.php#L9)
