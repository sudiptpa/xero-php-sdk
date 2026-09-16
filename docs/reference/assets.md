# Assets reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Assets\Asset\Asset](#assetsassetasset)
- [Assets\Asset\Assets](#assetsassetassets)
- [Assets\Asset\BookDepreciationDetail](#assetsassetbookdepreciationdetail)
- [Assets\Asset\BookDepreciationSetting](#assetsassetbookdepreciationsetting)
- [Assets\Asset\Payload](#assetsassetpayload)
- [Assets\Assets](#assetsassets)
- [Assets\Settings\Settings](#assetssettingssettings)
- [Assets\Type\Payload](#assetstypepayload)
- [Assets\Type\Type](#assetstypetype)
- [Assets\Type\Types](#assetstypetypes)

## Assets\Asset\Asset

[Source](../../src/Assets/Asset/Asset.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `assetId` | string or null | `()` |
| `assetName` | string or null | `()` |
| `assetTypeId` | string or null | `()` |
| `assetNumber` | string or null | `()` |
| `purchaseDate` | string or null | `()` |
| `purchasePrice` | int, float, or null | `()` |
| `disposalDate` | string or null | `()` |
| `disposalPrice` | int, float, or null | `()` |
| `assetStatus` | string or null | `()` |
| `warrantyExpiryDate` | string or null | `()` |
| `serialNumber` | string or null | `()` |
| `bookDepreciationSetting` | object or null ([Assets\Asset\BookDepreciationSetting](assets.md#assetsassetbookdepreciationsetting)) | `()` |
| `bookDepreciationDetail` | object or null ([Assets\Asset\BookDepreciationDetail](assets.md#assetsassetbookdepreciationdetail)) | `()` |
| `canRollback` | bool or null | `()` |
| `accountingBookValue` | int, float, or null | `()` |
| `isDeleteEnabledForDate` | bool or null | `()` |

### Public methods

- [`getAssetId(): ?string`](../../src/Assets/Asset/Asset.php#L44)
- [`setAssetId(?string $assetId): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L49)
- [`getAssetName(): ?string`](../../src/Assets/Asset/Asset.php#L56)
- [`setAssetName(?string $assetName): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L61)
- [`getAssetTypeId(): ?string`](../../src/Assets/Asset/Asset.php#L68)
- [`setAssetTypeId(?string $assetTypeId): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L73)
- [`getAssetNumber(): ?string`](../../src/Assets/Asset/Asset.php#L80)
- [`setAssetNumber(?string $assetNumber): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L85)
- [`getPurchaseDate(): ?string`](../../src/Assets/Asset/Asset.php#L92)
- [`setPurchaseDate(?string $purchaseDate): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L97)
- [`getPurchasePrice(): int\|float\|null`](../../src/Assets/Asset/Asset.php#L104)
- [`setPurchasePrice(int\|float\|null $purchasePrice): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L109)
- [`getDisposalDate(): ?string`](../../src/Assets/Asset/Asset.php#L116)
- [`setDisposalDate(?string $disposalDate): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L121)
- [`getDisposalPrice(): int\|float\|null`](../../src/Assets/Asset/Asset.php#L128)
- [`setDisposalPrice(int\|float\|null $disposalPrice): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L133)
- [`getAssetStatus(): ?string`](../../src/Assets/Asset/Asset.php#L140)
- [`setAssetStatus(?string $assetStatus): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L145)
- [`getWarrantyExpiryDate(): ?string`](../../src/Assets/Asset/Asset.php#L152)
- [`setWarrantyExpiryDate(?string $warrantyExpiryDate): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L157)
- [`getSerialNumber(): ?string`](../../src/Assets/Asset/Asset.php#L164)
- [`setSerialNumber(?string $serialNumber): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L169)
- [`getBookDepreciationSetting(): ?\Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/Asset.php#L176)
- [`setBookDepreciationSetting(?\Sujip\Xero\Assets\Asset\BookDepreciationSetting $bookDepreciationSetting): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L181)
- [`getBookDepreciationDetail(): ?\Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/Asset.php#L188)
- [`setBookDepreciationDetail(?\Sujip\Xero\Assets\Asset\BookDepreciationDetail $bookDepreciationDetail): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L193)
- [`getCanRollback(): ?bool`](../../src/Assets/Asset/Asset.php#L200)
- [`setCanRollback(?bool $canRollback): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L205)
- [`getAccountingBookValue(): int\|float\|null`](../../src/Assets/Asset/Asset.php#L212)
- [`setAccountingBookValue(int\|float\|null $accountingBookValue): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L217)
- [`getIsDeleteEnabledForDate(): ?bool`](../../src/Assets/Asset/Asset.php#L224)
- [`setIsDeleteEnabledForDate(?bool $isDeleteEnabledForDate): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Asset.php#L229)

## Assets\Asset\Assets

[Source](../../src/Assets/Asset/Assets.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Assets/Asset/Assets.php#L30)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Assets/Asset/Assets.php#L35)
- [`status(string $status): Sujip\Xero\Assets\Asset\Assets`](../../src/Assets/Asset/Assets.php#L43)
- [`page(int $page): Sujip\Xero\Assets\Asset\Assets`](../../src/Assets/Asset/Assets.php#L51)
- [`perPage(int $pageSize): Sujip\Xero\Assets\Asset\Assets`](../../src/Assets/Asset/Assets.php#L59)
- [`orderBy(string $field, string $direction = 'ASC'): Sujip\Xero\Assets\Asset\Assets`](../../src/Assets/Asset/Assets.php#L67)
- [`filterBy(string $value): Sujip\Xero\Assets\Asset\Assets`](../../src/Assets/Asset/Assets.php#L76)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Assets/Asset/Assets.php#L87)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Assets/Asset/Assets.php#L103)
- [`find(string $assetId): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Assets.php#L123)
- [`create(): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Assets.php#L132)
- [`mapAsset(array $asset): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Assets.php#L174)

## Assets\Asset\BookDepreciationDetail

[Source](../../src/Assets/Asset/BookDepreciationDetail.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `currentCapitalGain` | int, float, or null | `()` |
| `currentGainLoss` | int, float, or null | `()` |
| `depreciationStartDate` | string or null | `()` |
| `costLimit` | int, float, or null | `()` |
| `residualValue` | int, float, or null | `()` |
| `priorAccumDepreciationAmount` | int, float, or null | `()` |
| `currentAccumDepreciationAmount` | int, float, or null | `()` |
| `businessUseCapitalGain` | int, float, or null | `()` |
| `businessUseCurrentGainLoss` | int, float, or null | `()` |
| `privateUseCapitalGain` | int, float, or null | `()` |
| `privateUseCurrentGainLoss` | int, float, or null | `()` |
| `initialDeductionPercentage` | int, float, or null | `()` |

### Public methods

- [`getCurrentCapitalGain(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L36)
- [`setCurrentCapitalGain(int\|float\|null $currentCapitalGain): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L41)
- [`getCurrentGainLoss(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L48)
- [`setCurrentGainLoss(int\|float\|null $currentGainLoss): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L53)
- [`getDepreciationStartDate(): ?string`](../../src/Assets/Asset/BookDepreciationDetail.php#L60)
- [`setDepreciationStartDate(?string $depreciationStartDate): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L65)
- [`getCostLimit(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L72)
- [`setCostLimit(int\|float\|null $costLimit): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L77)
- [`getResidualValue(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L84)
- [`setResidualValue(int\|float\|null $residualValue): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L89)
- [`getPriorAccumDepreciationAmount(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L96)
- [`setPriorAccumDepreciationAmount(int\|float\|null $priorAccumDepreciationAmount): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L101)
- [`getCurrentAccumDepreciationAmount(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L108)
- [`setCurrentAccumDepreciationAmount(int\|float\|null $currentAccumDepreciationAmount): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L113)
- [`getBusinessUseCapitalGain(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L120)
- [`setBusinessUseCapitalGain(int\|float\|null $businessUseCapitalGain): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L125)
- [`getBusinessUseCurrentGainLoss(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L132)
- [`setBusinessUseCurrentGainLoss(int\|float\|null $businessUseCurrentGainLoss): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L137)
- [`getPrivateUseCapitalGain(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L144)
- [`setPrivateUseCapitalGain(int\|float\|null $privateUseCapitalGain): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L149)
- [`getPrivateUseCurrentGainLoss(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L156)
- [`setPrivateUseCurrentGainLoss(int\|float\|null $privateUseCurrentGainLoss): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L161)
- [`getInitialDeductionPercentage(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationDetail.php#L168)
- [`setInitialDeductionPercentage(int\|float\|null $initialDeductionPercentage): Sujip\Xero\Assets\Asset\BookDepreciationDetail`](../../src/Assets/Asset/BookDepreciationDetail.php#L173)

## Assets\Asset\BookDepreciationSetting

[Source](../../src/Assets/Asset/BookDepreciationSetting.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `depreciationMethod` | string or null | `()` |
| `averagingMethod` | string or null | `()` |
| `depreciationRate` | int, float, or null | `()` |
| `effectiveLifeYears` | int, float, or null | `()` |
| `depreciationCalculationMethod` | string or null | `()` |
| `depreciableObjectId` | string or null | `()` |
| `depreciableObjectType` | string or null | `()` |
| `bookEffectiveDateOfChangeId` | string or null | `()` |

### Public methods

- [`getDepreciationMethod(): ?string`](../../src/Assets/Asset/BookDepreciationSetting.php#L28)
- [`setDepreciationMethod(?string $depreciationMethod): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L33)
- [`getAveragingMethod(): ?string`](../../src/Assets/Asset/BookDepreciationSetting.php#L40)
- [`setAveragingMethod(?string $averagingMethod): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L45)
- [`getDepreciationRate(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationSetting.php#L52)
- [`setDepreciationRate(int\|float\|null $depreciationRate): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L57)
- [`getEffectiveLifeYears(): int\|float\|null`](../../src/Assets/Asset/BookDepreciationSetting.php#L64)
- [`setEffectiveLifeYears(int\|float\|null $effectiveLifeYears): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L69)
- [`getDepreciationCalculationMethod(): ?string`](../../src/Assets/Asset/BookDepreciationSetting.php#L76)
- [`setDepreciationCalculationMethod(?string $depreciationCalculationMethod): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L81)
- [`getDepreciableObjectId(): ?string`](../../src/Assets/Asset/BookDepreciationSetting.php#L88)
- [`setDepreciableObjectId(?string $depreciableObjectId): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L93)
- [`getDepreciableObjectType(): ?string`](../../src/Assets/Asset/BookDepreciationSetting.php#L100)
- [`setDepreciableObjectType(?string $depreciableObjectType): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L105)
- [`getBookEffectiveDateOfChangeId(): ?string`](../../src/Assets/Asset/BookDepreciationSetting.php#L112)
- [`setBookEffectiveDateOfChangeId(?string $bookEffectiveDateOfChangeId): Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Asset/BookDepreciationSetting.php#L117)

## Assets\Asset\Payload

[Source](../../src/Assets/Asset/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Assets/Asset/Payload.php#L31)
- [`name(string $name): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L36)
- [`number(string $number): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L44)
- [`status(string $status): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L52)
- [`assetType(string $assetTypeId): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L60)
- [`purchaseDate(string $purchaseDate): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L68)
- [`purchasePrice(int\|float $purchasePrice): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L76)
- [`serialNumber(string $serialNumber): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L84)
- [`warrantyExpiryDate(string $warrantyExpiryDate): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L92)
- [`idempotencyKey(string $key): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Asset/Payload.php#L100)
- [`save(): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Asset/Payload.php#L108)

## Assets\Assets

[Source](../../src/Assets/Assets.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Assets/Assets.php#L24)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Assets/Assets.php#L30)
- [`status(string $status): Sujip\Xero\Assets\Assets`](../../src/Assets/Assets.php#L35)
- [`page(int $page): Sujip\Xero\Assets\Assets`](../../src/Assets/Assets.php#L43)
- [`perPage(int $perPage): Sujip\Xero\Assets\Assets`](../../src/Assets/Assets.php#L51)
- [`orderBy(string $field, string $direction = 'ASC'): Sujip\Xero\Assets\Assets`](../../src/Assets/Assets.php#L59)
- [`filterBy(string $value): Sujip\Xero\Assets\Assets`](../../src/Assets/Assets.php#L67)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Assets/Assets.php#L78)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Assets/Assets.php#L86)
- [`find(string $assetId): Sujip\Xero\Assets\Asset\Asset`](../../src/Assets/Assets.php#L91)
- [`create(): Sujip\Xero\Assets\Asset\Payload`](../../src/Assets/Assets.php#L96)
- [`assetTypes(): Sujip\Xero\Assets\Type\Types`](../../src/Assets/Assets.php#L101)
- [`getAssetTypes(): Sujip\Xero\Support\ResourceCollection`](../../src/Assets/Assets.php#L109)
- [`createAssetType(): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Assets.php#L114)
- [`settings(): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Assets.php#L119)
- [`client(): Sujip\Xero\Client`](../../src/Assets/Assets.php#L124)

## Assets\Settings\Settings

[Source](../../src/Assets/Settings/Settings.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `assetNumberPrefix` | string or null | `()` |
| `assetNumberSequence` | string or null | `()` |
| `assetStartDate` | string or null | `()` |
| `lastDepreciationDate` | string or null | `()` |
| `defaultGainOnDisposalAccountId` | string or null | `()` |
| `defaultLossOnDisposalAccountId` | string or null | `()` |
| `defaultCapitalGainOnDisposalAccountId` | string or null | `()` |
| `optInForTax` | bool or null | `()` |

### Public methods

- [`fetch(\Sujip\Xero\Client $client): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L29)
- [`getAssetNumberPrefix(): ?string`](../../src/Assets/Settings/Settings.php#L38)
- [`setAssetNumberPrefix(?string $assetNumberPrefix): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L43)
- [`getAssetNumberSequence(): ?string`](../../src/Assets/Settings/Settings.php#L50)
- [`setAssetNumberSequence(?string $assetNumberSequence): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L55)
- [`getAssetStartDate(): ?string`](../../src/Assets/Settings/Settings.php#L62)
- [`setAssetStartDate(?string $assetStartDate): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L67)
- [`getLastDepreciationDate(): ?string`](../../src/Assets/Settings/Settings.php#L74)
- [`setLastDepreciationDate(?string $lastDepreciationDate): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L79)
- [`getDefaultGainOnDisposalAccountId(): ?string`](../../src/Assets/Settings/Settings.php#L86)
- [`setDefaultGainOnDisposalAccountId(?string $defaultGainOnDisposalAccountId): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L91)
- [`getDefaultLossOnDisposalAccountId(): ?string`](../../src/Assets/Settings/Settings.php#L98)
- [`setDefaultLossOnDisposalAccountId(?string $defaultLossOnDisposalAccountId): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L103)
- [`getDefaultCapitalGainOnDisposalAccountId(): ?string`](../../src/Assets/Settings/Settings.php#L110)
- [`setDefaultCapitalGainOnDisposalAccountId(?string $defaultCapitalGainOnDisposalAccountId): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L115)
- [`getOptInForTax(): ?bool`](../../src/Assets/Settings/Settings.php#L122)
- [`setOptInForTax(?bool $optInForTax): Sujip\Xero\Assets\Settings\Settings`](../../src/Assets/Settings/Settings.php#L127)

## Assets\Type\Payload

[Source](../../src/Assets/Type/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Assets/Type/Payload.php#L31)
- [`name(string $name): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L36)
- [`fixedAssetAccount(string $accountId): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L44)
- [`depreciationExpenseAccount(string $accountId): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L52)
- [`accumulatedDepreciationAccount(string $accountId): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L60)
- [`depreciationMethod(string $method): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L68)
- [`averagingMethod(string $method): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L76)
- [`depreciationRate(int\|float $rate): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L84)
- [`depreciationCalculationMethod(string $method): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L92)
- [`idempotencyKey(string $key): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Payload.php#L100)
- [`save(): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Payload.php#L108)

## Assets\Type\Type

[Source](../../src/Assets/Type/Type.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `assetTypeId` | string or null | `()` |
| `assetTypeName` | string or null | `()` |
| `fixedAssetAccountId` | string or null | `()` |
| `depreciationExpenseAccountId` | string or null | `()` |
| `accumulatedDepreciationAccountId` | string or null | `()` |
| `bookDepreciationSetting` | object or null ([Assets\Asset\BookDepreciationSetting](assets.md#assetsassetbookdepreciationsetting)) | `()` |
| `locks` | int, float, or null | `()` |

### Public methods

- [`getAssetTypeId(): ?string`](../../src/Assets/Type/Type.php#L27)
- [`setAssetTypeId(?string $assetTypeId): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Type.php#L32)
- [`getAssetTypeName(): ?string`](../../src/Assets/Type/Type.php#L39)
- [`setAssetTypeName(?string $assetTypeName): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Type.php#L44)
- [`getFixedAssetAccountId(): ?string`](../../src/Assets/Type/Type.php#L51)
- [`setFixedAssetAccountId(?string $fixedAssetAccountId): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Type.php#L56)
- [`getDepreciationExpenseAccountId(): ?string`](../../src/Assets/Type/Type.php#L63)
- [`setDepreciationExpenseAccountId(?string $depreciationExpenseAccountId): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Type.php#L68)
- [`getAccumulatedDepreciationAccountId(): ?string`](../../src/Assets/Type/Type.php#L75)
- [`setAccumulatedDepreciationAccountId(?string $accumulatedDepreciationAccountId): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Type.php#L80)
- [`getBookDepreciationSetting(): ?\Sujip\Xero\Assets\Asset\BookDepreciationSetting`](../../src/Assets/Type/Type.php#L87)
- [`setBookDepreciationSetting(?\Sujip\Xero\Assets\Asset\BookDepreciationSetting $bookDepreciationSetting): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Type.php#L92)
- [`getLocks(): int\|float\|null`](../../src/Assets/Type/Type.php#L99)
- [`setLocks(int\|float\|null $locks): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Type.php#L104)

## Assets\Type\Types

[Source](../../src/Assets/Type/Types.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Assets/Type/Types.php#L17)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Assets/Type/Types.php#L22)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Assets/Type/Types.php#L33)
- [`create(): Sujip\Xero\Assets\Type\Payload`](../../src/Assets/Type/Types.php#L45)
- [`mapType(array $type): Sujip\Xero\Assets\Type\Type`](../../src/Assets/Type/Types.php#L53)
