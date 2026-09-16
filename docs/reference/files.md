# Files reference

[Reference index](index.md)

Public types, model fields, and method signatures for this SDK area.

Model setters update the local object. Write builders send only the fields they
include in their request payload. Array fields may contain nested API objects
without a dedicated SDK model.

## Types

- [Files\File\Association](#filesfileassociation)
- [Files\File\AssociationCount](#filesfileassociationcount)
- [Files\File\AssociationPayload](#filesfileassociationpayload)
- [Files\File\Associations](#filesfileassociations)
- [Files\File\File](#filesfilefile)
- [Files\File\Files](#filesfilefiles)
- [Files\File\ObjectAssociations](#filesfileobjectassociations)
- [Files\File\Payload](#filesfilepayload)
- [Files\File\Upload](#filesfileupload)
- [Files\File\User](#filesfileuser)
- [Files\Files](#filesfiles)
- [Files\Folder\Folder](#filesfolderfolder)
- [Files\Folder\Folders](#filesfolderfolders)
- [Files\Folder\Payload](#filesfolderpayload)

## Files\File\Association

[Source](../../src/Files/File/Association.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `FileId` | string or null | `setFileId()` |
| `ObjectId` | string or null | `setObjectId()` |
| `ObjectGroup` | string or null | `setObjectGroup()` |
| `ObjectType` | string or null | `setObjectType()` |
| `SendWithObject` | bool or null | `setSendWithObject()` |
| `Name` | string or null | `setName()` |
| `Size` | int, float, or null | `setSize()` |
| `CreatedDateUtc` | string or null | `setCreatedDateUTC()` |
| `AssociationDateUtc` | string or null | `setAssociationDateUTC()` |

### Public methods

- [`__construct(?string $fileId = NULL, ?string $objectId = NULL, ?string $objectGroup = NULL, ?string $objectType = NULL, ?bool $sendWithObject = NULL, ?string $name = NULL, int\|float\|null $size = NULL, ?string $createdDateUtc = NULL, ?string $associationDateUtc = NULL)`](../../src/Files/File/Association.php#L12)
- [`getFileId(): ?string`](../../src/Files/File/Association.php#L25)
- [`setFileId(?string $fileId): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L30)
- [`getObjectId(): ?string`](../../src/Files/File/Association.php#L37)
- [`setObjectId(?string $objectId): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L42)
- [`getObjectGroup(): ?string`](../../src/Files/File/Association.php#L49)
- [`setObjectGroup(?string $objectGroup): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L54)
- [`getObjectType(): ?string`](../../src/Files/File/Association.php#L61)
- [`setObjectType(?string $objectType): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L66)
- [`getSendWithObject(): ?bool`](../../src/Files/File/Association.php#L73)
- [`setSendWithObject(?bool $sendWithObject): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L78)
- [`getName(): ?string`](../../src/Files/File/Association.php#L85)
- [`setName(?string $name): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L90)
- [`getSize(): int\|float\|null`](../../src/Files/File/Association.php#L97)
- [`setSize(int\|float\|null $size): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L102)
- [`getCreatedDateUTC(): ?string`](../../src/Files/File/Association.php#L109)
- [`setCreatedDateUTC(?string $createdDateUtc): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L114)
- [`getAssociationDateUTC(): ?string`](../../src/Files/File/Association.php#L121)
- [`setAssociationDateUTC(?string $associationDateUtc): Sujip\Xero\Files\File\Association`](../../src/Files/File/Association.php#L126)

## Files\File\AssociationCount

[Source](../../src/Files/File/AssociationCount.php)

### Public methods

- [`__construct(?string $objectId = NULL, ?int $count = NULL)`](../../src/Files/File/AssociationCount.php#L13)
- [`getObjectId(): ?string`](../../src/Files/File/AssociationCount.php#L19)
- [`setObjectId(?string $objectId): Sujip\Xero\Files\File\AssociationCount`](../../src/Files/File/AssociationCount.php#L24)
- [`getCount(): ?int`](../../src/Files/File/AssociationCount.php#L31)
- [`setCount(?int $count): Sujip\Xero\Files\File\AssociationCount`](../../src/Files/File/AssociationCount.php#L36)

## Files\File\AssociationPayload

[Source](../../src/Files/File/AssociationPayload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $fileId)`](../../src/Files/File/AssociationPayload.php#L21)
- [`objectId(?string $objectId): Sujip\Xero\Files\File\AssociationPayload`](../../src/Files/File/AssociationPayload.php#L27)
- [`objectType(?string $objectType): Sujip\Xero\Files\File\AssociationPayload`](../../src/Files/File/AssociationPayload.php#L35)
- [`objectGroup(?string $objectGroup): Sujip\Xero\Files\File\AssociationPayload`](../../src/Files/File/AssociationPayload.php#L43)
- [`idempotencyKey(string $key): Sujip\Xero\Files\File\AssociationPayload`](../../src/Files/File/AssociationPayload.php#L51)
- [`save(): Sujip\Xero\Files\File\Association`](../../src/Files/File/AssociationPayload.php#L59)

## Files\File\Associations

[Source](../../src/Files/File/Associations.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $fileId)`](../../src/Files/File/Associations.php#L17)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Files/File/Associations.php#L23)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Files/File/Associations.php#L34)
- [`countFor(string ...$objectIds): Sujip\Xero\Support\ResourceCollection`](../../src/Files/File/Associations.php#L51)
- [`attach(string $objectId, string $objectType, ?string $objectGroup = NULL): Sujip\Xero\Files\File\AssociationPayload`](../../src/Files/File/Associations.php#L72)
- [`delete(string $objectId): bool`](../../src/Files/File/Associations.php#L80)
- [`mapAssociation(array $payload): Sujip\Xero\Files\File\Association`](../../src/Files/File/Associations.php#L92)

## Files\File\File

[Source](../../src/Files/File/File.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Id` | string or null | `()` |
| `Name` | string or null | `()` |
| `MimeType` | string or null | `()` |
| `Size` | int, float, or null | `()` |
| `CreatedDateUtc` | string or null | `setCreatedDateUTC()` |
| `UpdatedDateUtc` | string or null | `setUpdatedDateUTC()` |
| `FolderId` | string or null | `()` |
| `User` | object or null ([Files\File\User](files.md#filesfileuser)) | `setUser()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Files/File/File.php#L30)
- [`getId(): ?string`](../../src/Files/File/File.php#L35)
- [`setId(?string $id): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L40)
- [`getName(): ?string`](../../src/Files/File/File.php#L47)
- [`setName(?string $name): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L52)
- [`getMimeType(): ?string`](../../src/Files/File/File.php#L59)
- [`setMimeType(?string $mimeType): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L64)
- [`getSize(): string\|int\|null`](../../src/Files/File/File.php#L71)
- [`setSize(string\|int\|null $size): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L76)
- [`getFolderId(): ?string`](../../src/Files/File/File.php#L83)
- [`setFolderId(?string $folderId): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L88)
- [`getCreatedDateUTC(): ?string`](../../src/Files/File/File.php#L95)
- [`setCreatedDateUTC(?string $createdDateUtc): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L100)
- [`getUpdatedDateUTC(): ?string`](../../src/Files/File/File.php#L107)
- [`setUpdatedDateUTC(?string $updatedDateUtc): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L112)
- [`getUser(): ?\Sujip\Xero\Files\File\User`](../../src/Files/File/File.php#L119)
- [`setUser(?\Sujip\Xero\Files\File\User $user): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L124)
- [`rename(string $name): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L148)
- [`moveToFolder(string $folderId): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L153)
- [`save(): Sujip\Xero\Files\File\File`](../../src/Files/File/File.php#L158)
- [`content(): string`](../../src/Files/File/File.php#L177)
- [`associations(): Sujip\Xero\Files\File\Associations`](../../src/Files/File/File.php#L186)
- [`delete(): bool`](../../src/Files/File/File.php#L195)

## Files\File\Files

[Source](../../src/Files/File/Files.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, ?string $folderId = NULL)`](../../src/Files/File/Files.php#L26)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Files/File/Files.php#L32)
- [`page(int $page): Sujip\Xero\Files\File\Files`](../../src/Files/File/Files.php#L40)
- [`perPage(int $perPage): Sujip\Xero\Files\File\Files`](../../src/Files/File/Files.php#L48)
- [`orderBy(string $field, string $direction = 'ASC'): Sujip\Xero\Files\File\Files`](../../src/Files/File/Files.php#L56)
- [`inFolder(string $folderId): Sujip\Xero\Files\File\Files`](../../src/Files/File/Files.php#L65)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Files/File/Files.php#L73)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Files/File/Files.php#L89)
- [`find(string $fileId): ?\Sujip\Xero\Files\File\File`](../../src/Files/File/Files.php#L109)
- [`content(string $fileId): string`](../../src/Files/File/Files.php#L120)
- [`delete(string $fileId): bool`](../../src/Files/File/Files.php#L128)
- [`upload(string $name, string $content, ?string $filename = NULL): Sujip\Xero\Files\File\Upload`](../../src/Files/File/Files.php#L137)
- [`update(string $fileId): Sujip\Xero\Files\File\Payload`](../../src/Files/File/Files.php#L142)
- [`associations(string $fileId): Sujip\Xero\Files\File\Associations`](../../src/Files/File/Files.php#L147)
- [`forObject(string $objectId): Sujip\Xero\Files\File\ObjectAssociations`](../../src/Files/File/Files.php#L152)
- [`client(): Sujip\Xero\Client`](../../src/Files/File/Files.php#L157)
- [`mapFile(array $file): Sujip\Xero\Files\File\File`](../../src/Files/File/Files.php#L200)

## Files\File\ObjectAssociations

[Source](../../src/Files/File/ObjectAssociations.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $objectId)`](../../src/Files/File/ObjectAssociations.php#L26)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Files/File/ObjectAssociations.php#L32)
- [`page(int $page): Sujip\Xero\Files\File\ObjectAssociations`](../../src/Files/File/ObjectAssociations.php#L40)
- [`perPage(int $perPage): Sujip\Xero\Files\File\ObjectAssociations`](../../src/Files/File/ObjectAssociations.php#L48)
- [`orderBy(string $field, string $direction = 'ASC'): Sujip\Xero\Files\File\ObjectAssociations`](../../src/Files/File/ObjectAssociations.php#L56)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Files/File/ObjectAssociations.php#L68)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Files/File/ObjectAssociations.php#L86)

## Files\File\Payload

[Source](../../src/Files/File/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Files/File/Payload.php#L22)
- [`id(string $id): Sujip\Xero\Files\File\Payload`](../../src/Files/File/Payload.php#L27)
- [`name(string $name): Sujip\Xero\Files\File\Payload`](../../src/Files/File/Payload.php#L35)
- [`folder(string $folderId): Sujip\Xero\Files\File\Payload`](../../src/Files/File/Payload.php#L43)
- [`idempotencyKey(string $key): Sujip\Xero\Files\File\Payload`](../../src/Files/File/Payload.php#L51)
- [`save(): Sujip\Xero\Files\File\File`](../../src/Files/File/Payload.php#L59)

## Files\File\Upload

[Source](../../src/Files/File/Upload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client, string $name, string $content, ?string $filename = NULL, ?string $folderId = NULL)`](../../src/Files/File/Upload.php#L17)
- [`mimeType(string $mimeType): Sujip\Xero\Files\File\Upload`](../../src/Files/File/Upload.php#L26)
- [`idempotencyKey(string $key): Sujip\Xero\Files\File\Upload`](../../src/Files/File/Upload.php#L34)
- [`toFolder(string $folderId): Sujip\Xero\Files\File\Upload`](../../src/Files/File/Upload.php#L42)
- [`save(): Sujip\Xero\Files\File\File`](../../src/Files/File/Upload.php#L51)

## Files\File\User

[Source](../../src/Files/File/User.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Id` | string or null | `setId()` |
| `Name` | string or null | `setName()` |
| `FirstName` | string or null | `setFirstName()` |
| `LastName` | string or null | `setLastName()` |
| `FullName` | string or null | `setFullName()` |

### Public methods

- [`__construct(?string $id = NULL, ?string $name = NULL, ?string $firstName = NULL, ?string $lastName = NULL, ?string $fullName = NULL)`](../../src/Files/File/User.php#L12)
- [`getId(): ?string`](../../src/Files/File/User.php#L21)
- [`setId(?string $id): Sujip\Xero\Files\File\User`](../../src/Files/File/User.php#L26)
- [`getName(): ?string`](../../src/Files/File/User.php#L33)
- [`setName(?string $name): Sujip\Xero\Files\File\User`](../../src/Files/File/User.php#L38)
- [`getFirstName(): ?string`](../../src/Files/File/User.php#L45)
- [`setFirstName(?string $firstName): Sujip\Xero\Files\File\User`](../../src/Files/File/User.php#L50)
- [`getLastName(): ?string`](../../src/Files/File/User.php#L57)
- [`setLastName(?string $lastName): Sujip\Xero\Files\File\User`](../../src/Files/File/User.php#L62)
- [`getFullName(): ?string`](../../src/Files/File/User.php#L69)
- [`setFullName(?string $fullName): Sujip\Xero\Files\File\User`](../../src/Files/File/User.php#L74)

## Files\Files

[Source](../../src/Files/Files.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Files/Files.php#L25)
- [`files(): Sujip\Xero\Files\File\Files`](../../src/Files/Files.php#L31)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Files/Files.php#L36)
- [`page(int $page): Sujip\Xero\Files\Files`](../../src/Files/Files.php#L41)
- [`perPage(int $perPage): Sujip\Xero\Files\Files`](../../src/Files/Files.php#L49)
- [`orderBy(string $field, string $direction = 'ASC'): Sujip\Xero\Files\Files`](../../src/Files/Files.php#L57)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Files/Files.php#L68)
- [`paginate(?int $page = NULL, ?int $perPage = NULL): Sujip\Xero\Support\PaginatedCollection`](../../src/Files/Files.php#L76)
- [`find(string $fileId): ?\Sujip\Xero\Files\File\File`](../../src/Files/Files.php#L81)
- [`content(string $fileId): string`](../../src/Files/Files.php#L86)
- [`delete(string $fileId): bool`](../../src/Files/Files.php#L91)
- [`upload(string $name, string $content, ?string $filename = NULL): Sujip\Xero\Files\File\Upload`](../../src/Files/Files.php#L96)
- [`update(string $fileId): Sujip\Xero\Files\File\Payload`](../../src/Files/Files.php#L101)
- [`associations(string $fileId): Sujip\Xero\Files\File\Associations`](../../src/Files/Files.php#L106)
- [`forObject(string $objectId): Sujip\Xero\Files\File\ObjectAssociations`](../../src/Files/Files.php#L111)
- [`folders(): Sujip\Xero\Files\Folder\Folders`](../../src/Files/Files.php#L116)
- [`findFolder(string $folderId): ?\Sujip\Xero\Files\Folder\Folder`](../../src/Files/Files.php#L121)
- [`client(): Sujip\Xero\Client`](../../src/Files/Files.php#L126)

## Files\Folder\Folder

[Source](../../src/Files/Folder/Folder.php)

Extends [Support\Model](support.md#supportmodel). Inherited methods are documented on the parent type.

### Model fields

| API field | Hydrated value | Hydration method |
| --- | --- | --- |
| `Id` | string or null | `()` |
| `Name` | string or null | `()` |
| `FileCount` | int, float, or null | `()` |
| `Email` | string or null | `()` |
| `IsInbox` | bool or null | `()` |

### Public methods

- [`__construct(?\Sujip\Xero\Client $client = NULL)`](../../src/Files/Folder/Folder.php#L26)
- [`getId(): ?string`](../../src/Files/Folder/Folder.php#L31)
- [`setId(?string $id): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folder.php#L36)
- [`getName(): ?string`](../../src/Files/Folder/Folder.php#L43)
- [`setName(?string $name): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folder.php#L48)
- [`getFileCount(): string\|int\|null`](../../src/Files/Folder/Folder.php#L55)
- [`setFileCount(string\|int\|null $fileCount): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folder.php#L60)
- [`getEmail(): ?string`](../../src/Files/Folder/Folder.php#L67)
- [`setEmail(?string $email): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folder.php#L72)
- [`getIsInbox(): ?bool`](../../src/Files/Folder/Folder.php#L79)
- [`setIsInbox(?bool $isInbox): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folder.php#L84)
- [`name(string $name): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folder.php#L105)
- [`save(): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folder.php#L110)
- [`files(): Sujip\Xero\Files\File\Files`](../../src/Files/Folder/Folder.php#L129)
- [`upload(string $name, string $content, ?string $filename = NULL): Sujip\Xero\Files\File\Upload`](../../src/Files/Folder/Folder.php#L138)
- [`delete(): bool`](../../src/Files/Folder/Folder.php#L147)

## Files\Folder\Folders

[Source](../../src/Files/Folder/Folders.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Files/Folder/Folders.php#L19)
- [`scopes(): Sujip\Xero\Support\ScopeRequirements`](../../src/Files/Folder/Folders.php#L24)
- [`orderBy(string $field, string $direction = 'ASC'): Sujip\Xero\Files\Folder\Folders`](../../src/Files/Folder/Folders.php#L32)
- [`get(): Sujip\Xero\Support\ResourceCollection`](../../src/Files/Folder/Folders.php#L43)
- [`find(string $folderId): ?\Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folders.php#L56)
- [`inbox(): ?\Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folders.php#L66)
- [`create(): Sujip\Xero\Files\Folder\Payload`](../../src/Files/Folder/Folders.php#L76)
- [`update(string $folderId): Sujip\Xero\Files\Folder\Payload`](../../src/Files/Folder/Folders.php#L81)
- [`delete(string $folderId): bool`](../../src/Files/Folder/Folders.php#L86)
- [`mapFolder(array $folder): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Folders.php#L98)

## Files\Folder\Payload

[Source](../../src/Files/Folder/Payload.php)

### Public methods

- [`__construct(\Sujip\Xero\Client $client)`](../../src/Files/Folder/Payload.php#L19)
- [`id(string $id): Sujip\Xero\Files\Folder\Payload`](../../src/Files/Folder/Payload.php#L24)
- [`name(string $name): Sujip\Xero\Files\Folder\Payload`](../../src/Files/Folder/Payload.php#L32)
- [`idempotencyKey(string $key): Sujip\Xero\Files\Folder\Payload`](../../src/Files/Folder/Payload.php#L40)
- [`save(): Sujip\Xero\Files\Folder\Folder`](../../src/Files/Folder/Payload.php#L48)
