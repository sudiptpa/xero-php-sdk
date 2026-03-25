<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Files;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Files\Folder\Folder;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class FoldersTest extends TestCase
{
    public function test_it_can_list_and_find_folders(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'Id' => 'folder-1',
                'Name' => 'Contracts',
                'FileCount' => 3,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'Id' => 'folder-1',
                'Name' => 'Contracts',
                'FileCount' => 3,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $folders = $client->files()->folders()->orderBy('CreatedDateUTC', 'DESC')->get();
        $folder = $client->files()->folders()->find('folder-1');

        self::assertSame('/files.xro/1.0/Folders', $transport->requests()[0]->path);
        self::assertSame('CreatedDateUTC DESC', $transport->requests()[0]->query['sort']);
        self::assertInstanceOf(Folder::class, $folders->first());
        self::assertSame('/files.xro/1.0/Folders/folder-1', $transport->requests()[1]->path);
        self::assertSame('folder-1', $folder?->id);
    }

    public function test_it_can_fetch_the_inbox_folder(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Items' => [[
                    'Id' => 'inbox-1',
                    'Name' => 'Inbox',
                    'IsInbox' => true,
                    'Email' => 'inbox@xero.test',
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $inbox = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->folders()
            ->inbox();

        self::assertSame('/files.xro/1.0/Inbox', $transport->requests()[0]->path);
        self::assertTrue((bool) $inbox?->isInbox);
    }

    public function test_it_can_create_and_update_folders(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'Id' => 'folder-1',
                'Name' => 'Contracts',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'Id' => 'folder-1',
                'Name' => 'Contracts 2026',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->files()->folders()->create()->name('Contracts')->save();
        $updated = $created->name('Contracts 2026')->save();

        self::assertSame('POST', $transport->requests()[0]->method);
        self::assertSame('/files.xro/1.0/Folders', $transport->requests()[0]->path);
        self::assertSame('Contracts', $transport->requests()[0]->json['Name']);
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertSame('/files.xro/1.0/Folders/folder-1', $transport->requests()[1]->path);
        self::assertSame('Contracts 2026', $updated->name);
    }

    public function test_loaded_folder_can_list_its_files_and_upload_into_it(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'Id' => 'folder-1',
                'Name' => 'Contracts',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'Id' => 'file-1',
                'Name' => 'contract.pdf',
                'FolderId' => 'folder-1',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Items' => [[
                'Id' => 'file-2',
                'Name' => 'terms.pdf',
                'FolderId' => 'folder-1',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $folder = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->folders()
            ->find('folder-1');

        $files = $folder?->files()->get();
        $uploaded = $folder?->upload('terms.pdf', 'binary-content')
            ->mimeType('application/pdf')
            ->save();

        self::assertSame('/files.xro/1.0/Folders/folder-1/Files', $transport->requests()[1]->path);
        self::assertSame('/files.xro/1.0/Files/folder-1', $transport->requests()[2]->path);
        self::assertSame('terms.pdf', $uploaded?->name);
        self::assertSame('contract.pdf', $files?->first()?->name);
    }
}
