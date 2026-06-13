<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Files;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Files\File\Association;
use Sujip\Xero\Files\File\AssociationCount;
use Sujip\Xero\Files\File\File;
use Sujip\Xero\Files\File\Payload as FilePayload;
use Sujip\Xero\Files\File\User;
use Sujip\Xero\Files\Folder\Folder;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class FilesCoverageTest extends TestCase
{
    private function client(FakeTransport $transport): Client
    {
        return Xero::withAccessToken('token', $transport)->tenant('tenant-1');
    }

    public function test_files_facade_delegates_scopes_builders_and_accessors(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"Items":[]}')); // paginate -> get
        $transport->push(new Response(200, body: 'binary-content')); // content
        $transport->push(new Response(204)); // delete
        $transport->push(new Response(200, body: '{"Items":[{"Id":"file-1","Name":"Renamed"}]}')); // update -> save

        $client = $this->client($transport);
        $facade = $client->files();

        self::assertSame(['files'], $facade->scopes()->broad);
        self::assertSame($client, $facade->client());
        self::assertSame($client, $facade->files()->client());

        $paginated = $facade->orderBy('Name')->paginate(2, 10);
        self::assertSame(2, $paginated->page);
        self::assertSame('binary-content', $facade->content('file-1'));
        self::assertTrue($facade->delete('file-1'));

        $facade->update('file-1')->name('Renamed')->save();
        self::assertSame('PUT', $transport->requests()[3]->method);
    }

    public function test_file_model_getters_setters_and_nested_folder_hydration(): void
    {
        $file = (new File())
            ->setId('file-1')
            ->setName('contract.pdf')
            ->setMimeType('application/pdf')
            ->setSize(1024)
            ->setFolderId('folder-1')
            ->setCreatedDateUTC('2026-03-01T00:00:00')
            ->setUpdatedDateUTC('2026-03-02T00:00:00')
            ->setUser((new User())->setName('Jane'));

        self::assertSame('file-1', $file->getId());
        self::assertSame('application/pdf', $file->getMimeType());
        self::assertSame(1024, $file->getSize());
        self::assertSame('2026-03-01T00:00:00', $file->getCreatedDateUTC());
        self::assertSame('2026-03-02T00:00:00', $file->getUpdatedDateUTC());
        self::assertSame('Jane', $file->getUser()?->getName());

        $hydrated = (new File())->fill([
            'FolderId' => 'folder-9',
            'CreatedDateUtc' => '2026-03-01T00:00:00',
            'UpdatedDateUtc' => '2026-03-02T00:00:00',
            'User' => ['Id' => 'user-1', 'Name' => 'jane@example.com', 'FirstName' => 'Jane', 'LastName' => 'Doe', 'FullName' => 'Jane Doe'],
        ]);
        self::assertSame('folder-9', $hydrated->getFolderId());
        self::assertSame('2026-03-01T00:00:00', $hydrated->getCreatedDateUTC());
        self::assertSame('2026-03-02T00:00:00', $hydrated->getUpdatedDateUTC());
        self::assertSame('Jane Doe', $hydrated->getUser()?->getFullName());
    }

    public function test_file_entity_guards_and_association_navigation(): void
    {
        $guards = [
            ['save', 'Cannot save a file without a bound client context.'],
            ['content', 'Cannot fetch file content without a bound client context and file id.'],
            ['associations', 'Cannot access file associations without a bound client context and file id.'],
            ['delete', 'Cannot delete a file without a bound client context and file id.'],
        ];

        foreach ($guards as [$method, $message]) {
            try {
                (new File())->{$method}();
                self::fail("Expected RuntimeException for {$method}().");
            } catch (RuntimeException $e) {
                self::assertSame($message, $e->getMessage());
            }
        }

        $transport = (new FakeTransport())->push(new Response(200, body: '{"Items":[{"Id":"file-1"}]}'));
        $file = $this->client($transport)->files()->find('file-1');
        self::assertNotNull($file);
        self::assertSame(['files'], $file->associations()->scopes()->broad);
    }

    public function test_file_payload_supports_post_idempotency_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $file = (new FilePayload($this->client($transport)))
            ->name('contract.pdf')
            ->folder('folder-1')
            ->idempotencyKey('key-1')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('key-1', $request->headers['Idempotency-Key']);
        self::assertNull($file->getId());
    }

    public function test_upload_without_folder_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $file = $this->client($transport)->files()
            ->upload('notes.txt', 'plain text')
            ->save();

        self::assertSame('/files.xro/1.0/Files', $transport->requests()[0]->path);
        self::assertNull($file->getId());
    }

    public function test_association_models_expose_getters(): void
    {
        $association = (new Association())
            ->setObjectId('object-1')
            ->setObjectGroup('Invoices');

        self::assertSame('object-1', $association->getObjectId());
        self::assertSame('Invoices', $association->getObjectGroup());

        $count = (new AssociationCount())
            ->setObjectId('object-1')
            ->setCount(3);

        self::assertSame('object-1', $count->getObjectId());
        self::assertSame(3, $count->getCount());
    }

    public function test_associations_and_object_associations_scopes_and_pagination(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"Items":[{"Id":"file-1"}]}'));

        $client = $this->client($transport);

        self::assertSame(['files'], $client->files()->associations('file-1')->scopes()->broad);

        $forObject = $client->files()->forObject('object-1');
        self::assertSame(['files'], $forObject->scopes()->broad);

        $paginated = $forObject->paginate(2, 10);
        self::assertSame(2, $paginated->page);
    }

    public function test_folder_model_getters_and_entity_guards(): void
    {
        $folder = (new Folder())
            ->setFileCount(5)
            ->setEmail('inbox@example.com');

        self::assertSame(5, $folder->getFileCount());
        self::assertSame('inbox@example.com', $folder->getEmail());

        $guards = [
            ['save', 'Cannot save a folder without a bound client context.'],
            ['files', 'Cannot access folder files without a bound client context and folder id.'],
            ['delete', 'Cannot delete a folder without a bound client context and folder id.'],
        ];

        foreach ($guards as [$method, $message]) {
            try {
                (new Folder())->{$method}();
                self::fail("Expected RuntimeException for {$method}().");
            } catch (RuntimeException $e) {
                self::assertSame($message, $e->getMessage());
            }
        }

        try {
            (new Folder())->upload('n', 'c');
            self::fail('Expected RuntimeException for upload().');
        } catch (RuntimeException $e) {
            self::assertSame('Cannot upload into a folder without a bound client context and folder id.', $e->getMessage());
        }
    }

    public function test_folders_scopes_update_and_payload_idempotency(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"Items":[{"Id":"folder-1","Name":"Renamed"}]}')); // update -> save
        $transport->push(new Response(200, body: '{}')); // create -> save (empty)

        $folders = $this->client($transport)->files()->folders();

        self::assertSame(['files'], $folders->scopes()->broad);

        $folders->update('folder-1')->name('Renamed')->save();
        self::assertSame('PUT', $transport->requests()[0]->method);

        $created = $folders->create()->name('Contracts')->idempotencyKey('key-2')->save();
        self::assertSame('key-2', $transport->requests()[1]->headers['Idempotency-Key']);
        self::assertNull($created->getId());
    }
}
