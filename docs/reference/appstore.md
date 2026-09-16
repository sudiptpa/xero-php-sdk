# App Store reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [AppStore\AppStore](#appstoreappstore)
- [AppStore\Subscription\Plan](#appstoresubscriptionplan)
- [AppStore\Subscription\Price](#appstoresubscriptionprice)
- [AppStore\Subscription\Product](#appstoresubscriptionproduct)
- [AppStore\Subscription\Subscription](#appstoresubscriptionsubscription)
- [AppStore\Subscription\SubscriptionItem](#appstoresubscriptionsubscriptionitem)
- [AppStore\Subscription\Subscriptions](#appstoresubscriptionsubscriptions)
- [AppStore\Subscription\UsageRecord](#appstoresubscriptionusagerecord)
- [AppStore\Subscription\UsageRecordPayload](#appstoresubscriptionusagerecordpayload)

## AppStore\AppStore

[Source](../../src/AppStore/AppStore.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/AppStore/AppStore.php#L14)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/AppStore/AppStore.php#L19)
- [`subscriptions(): Sujip\Xero\AppStore\Subscription\Subscriptions`](../../src/AppStore/AppStore.php#L27)

## AppStore\Subscription\Plan

[Source](../../src/AppStore/Subscription/Plan.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `setId()` |
| `name` | string or null | `setName()` |
| `status` | string or null | `setStatus()` |
| `subscriptionItems` | list of objects ([AppStore\Subscription\SubscriptionItem](appstore.md#appstoresubscriptionsubscriptionitem)) | `addSubscriptionItem()` |

### Public methods

- [`__construct(?string $id = NULL, ?string $name = NULL, ?string $status = NULL, array $subscriptionItems = array (
))`](../../src/AppStore/Subscription/Plan.php#L15)
- [`getId(): ?string`](../../src/AppStore/Subscription/Plan.php#L23)
- [`setId(?string $id): Sujip\Xero\AppStore\Subscription\Plan`](../../src/AppStore/Subscription/Plan.php#L28)
- [`getName(): ?string`](../../src/AppStore/Subscription/Plan.php#L35)
- [`setName(?string $name): Sujip\Xero\AppStore\Subscription\Plan`](../../src/AppStore/Subscription/Plan.php#L40)
- [`getStatus(): ?string`](../../src/AppStore/Subscription/Plan.php#L47)
- [`setStatus(?string $status): Sujip\Xero\AppStore\Subscription\Plan`](../../src/AppStore/Subscription/Plan.php#L52)
- [`getSubscriptionItems(): array`](../../src/AppStore/Subscription/Plan.php#L62)
- [`setSubscriptionItems(array $subscriptionItems): Sujip\Xero\AppStore\Subscription\Plan`](../../src/AppStore/Subscription/Plan.php#L70)
- [`addSubscriptionItem(\Sujip\Xero\AppStore\Subscription\SubscriptionItem $subscriptionItem): Sujip\Xero\AppStore\Subscription\Plan`](../../src/AppStore/Subscription/Plan.php#L77)

## AppStore\Subscription\Price

[Source](../../src/AppStore/Subscription/Price.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `setId()` |
| `amount` | int, float, or null | `setAmount()` |
| `currency` | string or null | `setCurrency()` |

### Public methods

- [`__construct(?string $id = NULL, int\|float\|null $amount = NULL, ?string $currency = NULL)`](../../src/AppStore/Subscription/Price.php#L12)
- [`getId(): ?string`](../../src/AppStore/Subscription/Price.php#L19)
- [`setId(?string $id): Sujip\Xero\AppStore\Subscription\Price`](../../src/AppStore/Subscription/Price.php#L24)
- [`getAmount(): int\|float\|null`](../../src/AppStore/Subscription/Price.php#L31)
- [`setAmount(int\|float\|null $amount): Sujip\Xero\AppStore\Subscription\Price`](../../src/AppStore/Subscription/Price.php#L36)
- [`getCurrency(): ?string`](../../src/AppStore/Subscription/Price.php#L43)
- [`setCurrency(?string $currency): Sujip\Xero\AppStore\Subscription\Price`](../../src/AppStore/Subscription/Price.php#L48)

## AppStore\Subscription\Product

[Source](../../src/AppStore/Subscription/Product.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `setId()` |
| `name` | string or null | `setName()` |
| `type` | string or null | `setType()` |
| `seatUnit` | string or null | `setSeatUnit()` |
| `usageUnit` | string or null | `setUsageUnit()` |

### Public methods

- [`__construct(?string $id = NULL, ?string $name = NULL, ?string $type = NULL, ?string $seatUnit = NULL, ?string $usageUnit = NULL)`](../../src/AppStore/Subscription/Product.php#L12)
- [`getId(): ?string`](../../src/AppStore/Subscription/Product.php#L21)
- [`setId(?string $id): Sujip\Xero\AppStore\Subscription\Product`](../../src/AppStore/Subscription/Product.php#L26)
- [`getName(): ?string`](../../src/AppStore/Subscription/Product.php#L33)
- [`setName(?string $name): Sujip\Xero\AppStore\Subscription\Product`](../../src/AppStore/Subscription/Product.php#L38)
- [`getType(): ?string`](../../src/AppStore/Subscription/Product.php#L45)
- [`setType(?string $type): Sujip\Xero\AppStore\Subscription\Product`](../../src/AppStore/Subscription/Product.php#L50)
- [`getSeatUnit(): ?string`](../../src/AppStore/Subscription/Product.php#L57)
- [`setSeatUnit(?string $seatUnit): Sujip\Xero\AppStore\Subscription\Product`](../../src/AppStore/Subscription/Product.php#L62)
- [`getUsageUnit(): ?string`](../../src/AppStore/Subscription/Product.php#L69)
- [`setUsageUnit(?string $usageUnit): Sujip\Xero\AppStore\Subscription\Product`](../../src/AppStore/Subscription/Product.php#L74)

## AppStore\Subscription\Subscription

[Source](../../src/AppStore/Subscription/Subscription.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `setId()` |
| `organisationId` | string or null | `setOrganisationId()` |
| `status` | string or null | `setStatus()` |
| `startDate` | string or null | `setStartDate()` |
| `currentPeriodEnd` | string or null | `setCurrentPeriodEnd()` |
| `endDate` | string or null | `setEndDate()` |
| `testMode` | bool or null | `setTestMode()` |
| `plans` | list of objects ([AppStore\Subscription\Plan](appstore.md#appstoresubscriptionplan)) | `addPlan()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL, ?string $id = NULL, ?string $organisationId = NULL, ?string $status = NULL, ?string $startDate = NULL, ?string $currentPeriodEnd = NULL, ?string $endDate = NULL, ?bool $testMode = NULL, array $plans = array (
))`](../../src/AppStore/Subscription/Subscription.php#L18)
- [`getId(): ?string`](../../src/AppStore/Subscription/Subscription.php#L31)
- [`setId(?string $id): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L36)
- [`getOrganisationId(): ?string`](../../src/AppStore/Subscription/Subscription.php#L43)
- [`setOrganisationId(?string $organisationId): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L48)
- [`getStatus(): ?string`](../../src/AppStore/Subscription/Subscription.php#L55)
- [`setStatus(?string $status): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L60)
- [`getStartDate(): ?string`](../../src/AppStore/Subscription/Subscription.php#L67)
- [`setStartDate(?string $startDate): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L72)
- [`getCurrentPeriodEnd(): ?string`](../../src/AppStore/Subscription/Subscription.php#L79)
- [`setCurrentPeriodEnd(?string $currentPeriodEnd): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L84)
- [`getEndDate(): ?string`](../../src/AppStore/Subscription/Subscription.php#L91)
- [`setEndDate(?string $endDate): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L96)
- [`getTestMode(): ?bool`](../../src/AppStore/Subscription/Subscription.php#L103)
- [`setTestMode(?bool $testMode): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L108)
- [`getPlans(): array`](../../src/AppStore/Subscription/Subscription.php#L118)
- [`setPlans(array $plans): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L126)
- [`addPlan(\Sujip\Xero\AppStore\Subscription\Plan $plan): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscription.php#L133)
- [`usageRecords(): Sujip\Xero\Support\ResourceCollection`](../../src/AppStore/Subscription/Subscription.php#L160)
- [`recordUsage(): Sujip\Xero\AppStore\Subscription\UsageRecordPayload`](../../src/AppStore/Subscription/Subscription.php#L169)

## AppStore\Subscription\SubscriptionItem

[Source](../../src/AppStore/Subscription/SubscriptionItem.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `id` | string or null | `setId()` |
| `startDate` | string or null | `setStartDate()` |
| `endDate` | string or null | `setEndDate()` |
| `status` | string or null | `setStatus()` |
| `testMode` | bool or null | `setTestMode()` |
| `quantity` | int, float, or null | `setQuantity()` |
| `price` | object or null ([AppStore\Subscription\Price](appstore.md#appstoresubscriptionprice)) | `setPrice()` |
| `product` | object or null ([AppStore\Subscription\Product](appstore.md#appstoresubscriptionproduct)) | `setProduct()` |

### Public methods

- [`__construct(?string $id = NULL, ?string $startDate = NULL, ?string $endDate = NULL, ?string $status = NULL, ?bool $testMode = NULL, int\|float\|null $quantity = NULL, ?\Sujip\Xero\AppStore\Subscription\Price $price = NULL, ?\Sujip\Xero\AppStore\Subscription\Product $product = NULL)`](../../src/AppStore/Subscription/SubscriptionItem.php#L12)
- [`getId(): ?string`](../../src/AppStore/Subscription/SubscriptionItem.php#L24)
- [`setId(?string $id): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L29)
- [`getStartDate(): ?string`](../../src/AppStore/Subscription/SubscriptionItem.php#L36)
- [`setStartDate(?string $startDate): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L41)
- [`getEndDate(): ?string`](../../src/AppStore/Subscription/SubscriptionItem.php#L48)
- [`setEndDate(?string $endDate): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L53)
- [`getStatus(): ?string`](../../src/AppStore/Subscription/SubscriptionItem.php#L60)
- [`setStatus(?string $status): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L65)
- [`getTestMode(): ?bool`](../../src/AppStore/Subscription/SubscriptionItem.php#L72)
- [`setTestMode(?bool $testMode): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L77)
- [`getQuantity(): int\|float\|null`](../../src/AppStore/Subscription/SubscriptionItem.php#L84)
- [`setQuantity(int\|float\|null $quantity): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L89)
- [`getPrice(): ?\Sujip\Xero\AppStore\Subscription\Price`](../../src/AppStore/Subscription/SubscriptionItem.php#L96)
- [`setPrice(?\Sujip\Xero\AppStore\Subscription\Price $price): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L101)
- [`getProduct(): ?\Sujip\Xero\AppStore\Subscription\Product`](../../src/AppStore/Subscription/SubscriptionItem.php#L108)
- [`setProduct(?\Sujip\Xero\AppStore\Subscription\Product $product): Sujip\Xero\AppStore\Subscription\SubscriptionItem`](../../src/AppStore/Subscription/SubscriptionItem.php#L113)

## AppStore\Subscription\Subscriptions

[Source](../../src/AppStore/Subscription/Subscriptions.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/AppStore/Subscription/Subscriptions.php#L15)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/AppStore/Subscription/Subscriptions.php#L20)
- [`find(string $subscriptionId): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscriptions.php#L28)
- [`usageRecords(string $subscriptionId): Sujip\Xero\Support\ResourceCollection`](../../src/AppStore/Subscription/Subscriptions.php#L42)
- [`recordUsage(string $subscriptionId): Sujip\Xero\AppStore\Subscription\UsageRecordPayload`](../../src/AppStore/Subscription/Subscriptions.php#L58)
- [`updateUsage(string $subscriptionId, string $usageRecordId): Sujip\Xero\AppStore\Subscription\UsageRecordPayload`](../../src/AppStore/Subscription/Subscriptions.php#L63)
- [`mapSubscription(array $payload): Sujip\Xero\AppStore\Subscription\Subscription`](../../src/AppStore/Subscription/Subscriptions.php#L71)
- [`mapUsageRecord(array $payload): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/Subscriptions.php#L79)

## AppStore\Subscription\UsageRecord

[Source](../../src/AppStore/Subscription/UsageRecord.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `usageRecordId` | string or null | `setUsageRecordId()` |
| `subscriptionId` | string or null | `setSubscriptionId()` |
| `subscriptionItemId` | string or null | `setSubscriptionItemId()` |
| `productId` | string or null | `setProductId()` |
| `pricePerUnit` | int, float, or null | `setPricePerUnit()` |
| `quantity` | int, float, or null | `setQuantity()` |
| `testMode` | bool or null | `setTestMode()` |
| `recordedAt` | string or null | `setRecordedAt()` |

### Public methods

- [`__construct(?string $usageRecordId = NULL, ?string $subscriptionId = NULL, ?string $subscriptionItemId = NULL, ?string $productId = NULL, int\|float\|null $pricePerUnit = NULL, int\|float\|null $quantity = NULL, ?bool $testMode = NULL, ?string $recordedAt = NULL)`](../../src/AppStore/Subscription/UsageRecord.php#L12)
- [`getUsageRecordId(): ?string`](../../src/AppStore/Subscription/UsageRecord.php#L24)
- [`setUsageRecordId(?string $usageRecordId): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L29)
- [`getSubscriptionId(): ?string`](../../src/AppStore/Subscription/UsageRecord.php#L36)
- [`setSubscriptionId(?string $subscriptionId): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L41)
- [`getSubscriptionItemId(): ?string`](../../src/AppStore/Subscription/UsageRecord.php#L48)
- [`setSubscriptionItemId(?string $subscriptionItemId): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L53)
- [`getProductId(): ?string`](../../src/AppStore/Subscription/UsageRecord.php#L60)
- [`setProductId(?string $productId): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L65)
- [`getPricePerUnit(): int\|float\|null`](../../src/AppStore/Subscription/UsageRecord.php#L72)
- [`setPricePerUnit(int\|float\|null $pricePerUnit): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L77)
- [`getQuantity(): int\|float\|null`](../../src/AppStore/Subscription/UsageRecord.php#L84)
- [`setQuantity(int\|float\|null $quantity): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L89)
- [`getTestMode(): ?bool`](../../src/AppStore/Subscription/UsageRecord.php#L96)
- [`setTestMode(?bool $testMode): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L101)
- [`getRecordedAt(): ?string`](../../src/AppStore/Subscription/UsageRecord.php#L108)
- [`setRecordedAt(?string $recordedAt): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecord.php#L113)

## AppStore\Subscription\UsageRecordPayload

[Source](../../src/AppStore/Subscription/UsageRecordPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $subscriptionId)`](../../src/AppStore/Subscription/UsageRecordPayload.php#L21)
- [`id(string $usageRecordId): Sujip\Xero\AppStore\Subscription\UsageRecordPayload`](../../src/AppStore/Subscription/UsageRecordPayload.php#L27)
- [`item(string $subscriptionItemId): Sujip\Xero\AppStore\Subscription\UsageRecordPayload`](../../src/AppStore/Subscription/UsageRecordPayload.php#L35)
- [`quantity(int\|float $quantity): Sujip\Xero\AppStore\Subscription\UsageRecordPayload`](../../src/AppStore/Subscription/UsageRecordPayload.php#L43)
- [`timestamp(string $timestamp): Sujip\Xero\AppStore\Subscription\UsageRecordPayload`](../../src/AppStore/Subscription/UsageRecordPayload.php#L51)
- [`save(): Sujip\Xero\AppStore\Subscription\UsageRecord`](../../src/AppStore/Subscription/UsageRecordPayload.php#L59)
