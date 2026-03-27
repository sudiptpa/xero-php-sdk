# Files

The Files API gets messy fast if the SDK treats everything as raw upload plumbing. This package keeps it small and direct.

Current coverage:

- files
- file content
- file delete
- uploads
- folders
- folder delete
- inbox
- file associations
- object-side file association lookups
- association counts

## Files

```php
$files = $xero->files()
    ->orderBy('CreatedDateUTC', 'DESC')
    ->page(1)
    ->perPage(50)
    ->get();
```

```php
$file = $xero->files()
    ->find('file-id');

$content = $file?->content();
```

```php
$uploaded = $xero->files()
    ->upload('contract.pdf', $binary)
    ->mimeType('application/pdf')
    ->toFolder('folder-id')
    ->save();
```

Loaded files keep the same fluent style as the Accounting models:

```php
$renamed = $file?->rename('contract-v2.pdf')
    ->moveToFolder('folder-id')
    ->save();
```

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
```

```php
$folder = $xero->files()->findFolder('folder-id');

$folder?->delete();
```

Folders are first-class too:

```php
$uploaded = $folder?->upload('terms.pdf', $binary)
    ->mimeType('application/pdf')
    ->save();
```

## Scope Notes

Implemented Files resources use:

- broad `files`
- granular `files.read`, `files`

Use `files.read` for listing, lookup, content reads, inbox reads, and association reads.

Use `files` for uploads, metadata updates, folder writes, file deletes, and association writes.

If the integration only reads or downloads files, `files.read` is the right starting point.
