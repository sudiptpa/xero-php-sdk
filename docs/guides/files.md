# Files

Files, folders, uploads, and associations.

## List files

```php
$files = $xero->files()
    ->orderBy('CreatedDateUTC', 'DESC')
    ->page(1)
    ->perPage(50)
    ->get();
```

## Find a file

```php
$file = $xero->files()
    ->find('file-id');

$content = $file?->content();
$name = $file?->getName();
$folderId = $file?->getFolderId();
```

## Upload a file

```php
$uploaded = $xero->files()
    ->upload('contract.pdf', $binary)
    ->mimeType('application/pdf')
    ->toFolder('folder-id')
    ->save();
```

## Rename or move a file

```php
$renamed = $file?->rename('contract-v2.pdf')
    ->moveToFolder('folder-id')
    ->save();
```

## Delete a file

```php
$file?->delete();
```

## Associations

```php
$association = $xero->files()
    ->associations('file-id')
    ->attach('invoice-id', 'Invoice', 'Invoices')
    ->save();
```

```php
$files = $xero->files()
    ->forObject('invoice-id')
    ->orderBy('CreatedDateUTC', 'DESC')
    ->page(1)
    ->perPage(25)
    ->get();
```

```php
$xero->files()
    ->associations('file-id')
    ->delete('invoice-id');
```

```php
$counts = $xero->files()
    ->associations('file-id')
    ->countFor('invoice-id', 'contact-id');

$firstCount = $counts->first();
$objectId = $firstCount?->getObjectId();
$count = $firstCount?->getCount();
```

## Folders

```php
$folders = $xero->files()
    ->folders()
    ->orderBy('CreatedDateUTC', 'DESC')
    ->get();
```

```php
$folder = $xero->files()
    ->folders()
    ->create()
    ->name('Contracts')
    ->save();
```

```php
$inbox = $xero->files()
    ->folders()
    ->inbox();

$isInbox = $inbox?->getIsInbox();
```

```php
$folder = $xero->files()->findFolder('folder-id');

$folder?->delete();
```

```php
$uploaded = $folder?->upload('terms.pdf', $binary)
    ->mimeType('application/pdf')
    ->save();

$uploadedName = $uploaded?->getName();
```

## Scopes

- `files.read`: list files, find files, read file content, read inbox, read associations
- `files`: upload, rename, move, delete files; write folders; write associations
