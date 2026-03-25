# Files

The Files API is a good test of whether the package still feels calm once Xero moves beyond standard accounting resources.

The package now covers the first practical layer:

- files
- file content
- uploads
- folders
- inbox
- file associations

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

Loaded files keep the same fluent feel as the Accounting models:

```php
$renamed = $file?->rename('contract-v2.pdf')
    ->moveToFolder('folder-id')
    ->save();
```

## Associations

```php
$association = $xero->files()
    ->associations('file-id')
    ->attach('invoice-id', 'Invoice', 'Invoices')
    ->save();
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

Folders are first-class too, so once you have one you can work from there:

```php
$uploaded = $folder?->upload('terms.pdf', $binary)
    ->mimeType('application/pdf')
    ->save();
```

## Scope Notes

The current Files resources carry:

- broad scope: `files`
- granular scopes: `files.read`, `files`

That matches the current Xero Files API surface, where reads can use `files.read` and write actions need `files`.
