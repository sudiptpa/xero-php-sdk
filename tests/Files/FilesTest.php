<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Files;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class FilesTest extends TestCase
{
    public function test_it_can_list_files(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Items' => [[
                    'Id' => 'file-1',
                    'Name' => 'contract.pdf',
                    'MimeType' => 'application/pdf',
                    'Size' => 12345,
                ]],
            ], JSON_THROW_ON_ERROR))
        );

        $files = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->orderBy('CreatedDateUTC', 'DESC')
            ->page(2)
            ->perPage(50)
            ->get();

        $request = $transport->requests()[0];

        self::assertSame('/files.xro/1.0/Files', $request->path);
        self::assertSame('CreatedDateUTC', $request->query['sort']);
        self::assertSame('DESC', $request->query['direction']);
        self::assertSame(2, $request->query['page']);
        self::assertSame(50, $request->query['pagesize']);
        self::assertNotNull($files->first());
    }

    public function test_it_can_find_and_download_file_content(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Id' => 'file-1',
            'Name' => 'contract.pdf',
            'MimeType' => 'application/pdf',
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: 'pdf-binary-content'));

        $file = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->find('file-1');

        $content = $file?->content();

        self::assertSame('/files.xro/1.0/Files/file-1', $transport->requests()[0]->path);
        self::assertSame('/files.xro/1.0/Files/file-1/Content', $transport->requests()[1]->path);
        self::assertSame('pdf-binary-content', $content);
    }

    public function test_it_can_upload_a_file_to_a_folder(): void
    {
        $transport = (new FakeTransport())->push(
            new Response(200, body: json_encode([
                'Id' => 'file-1',
                'Name' => 'contract.pdf',
                'MimeType' => 'application/pdf',
                'FolderId' => 'folder-1',
            ], JSON_THROW_ON_ERROR))
        );

        $file = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->upload('contract.pdf', 'binary-data')
            ->mimeType('application/pdf')
            ->toFolder('folder-1')
            ->idempotencyKey('upload-key')
            ->save();

        $request = $transport->requests()[0];

        self::assertSame('POST', $request->method);
        self::assertSame('/files.xro/1.0/Files/folder-1', $request->path);
        self::assertStringStartsWith('multipart/form-data; boundary=', $request->headers['Content-Type']);
        self::assertSame('upload-key', $request->headers['Idempotency-Key']);
        self::assertStringContainsString('Content-Disposition: form-data; name="contract.pdf"; filename="contract.pdf"', $request->body ?? '');
        self::assertStringContainsString('Content-Type: application/pdf', $request->body ?? '');
        self::assertStringContainsString('binary-data', $request->body ?? '');
        self::assertSame('folder-1', $file->getFolderId());
    }

    public function test_loaded_file_can_be_changed_and_saved_fluently(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Id' => 'file-1',
            'Name' => 'contract.pdf',
            'FolderId' => 'folder-1',
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Id' => 'file-1',
            'Name' => 'contract-v2.pdf',
            'FolderId' => 'folder-2',
        ], JSON_THROW_ON_ERROR)));

        $file = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->find('file-1');

        $saved = $file?->rename('contract-v2.pdf')->moveToFolder('folder-2')->save();
        $request = $transport->requests()[1];

        self::assertSame('PUT', $request->method);
        self::assertSame('/files.xro/1.0/Files/file-1', $request->path);
        $json = $request->json ?? [];
        self::assertSame('contract-v2.pdf', $json['Name'] ?? null);
        self::assertSame('folder-2', $json['FolderId'] ?? null);
        self::assertSame('contract-v2.pdf', $saved?->getName());
    }

    public function test_it_can_list_and_create_file_associations(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([[
            'ObjectId' => 'invoice-1',
            'ObjectType' => 'Invoice',
            'ObjectGroup' => 'Invoices',
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(201, body: json_encode([
            'ObjectId' => 'invoice-2',
            'ObjectType' => 'Invoice',
            'ObjectGroup' => 'Invoices',
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $associations = $client->files()->associations('file-1')->get();
        $created = $client->files()->associations('file-1')
            ->attach('invoice-2', 'Invoice', 'Invoices')
            ->save();

        self::assertSame('/files.xro/1.0/Files/file-1/Associations', $transport->requests()[0]->path);
        self::assertNotNull($associations->first());
        self::assertSame('/files.xro/1.0/Files/file-1/Associations', $transport->requests()[1]->path);
        $json1 = $transport->requests()[1]->json ?? [];
        self::assertSame('invoice-2', $json1['ObjectId'] ?? null);
        self::assertSame('Invoice', $created->getObjectType());
    }

    public function test_it_can_list_files_associated_with_an_object_and_delete_an_association(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([[
            'FileId' => 'file-1',
            'ObjectId' => 'invoice-1',
            'ObjectGroup' => 'Invoices',
            'ObjectType' => 'Invoice',
            'Name' => 'invoice.pdf',
            'Size' => 1024,
        ]], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $associations = $client->files()
            ->forObject('invoice-1')
            ->orderBy('CreatedDateUTC', 'DESC')
            ->page(2)
            ->perPage(25)
            ->get();

        $deleted = $client->files()
            ->associations('file-1')
            ->delete('invoice-1');

        self::assertSame('/files.xro/1.0/Associations/invoice-1', $transport->requests()[0]->path);
        self::assertSame('CreatedDateUTC', $transport->requests()[0]->query['sort']);
        self::assertSame('DESC', $transport->requests()[0]->query['direction']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pagesize']);
        $association = $associations->first();
        self::assertNotNull($association);
        self::assertSame('file-1', $association->getFileId());
        self::assertSame('invoice.pdf', $association->getName());
        self::assertSame('/files.xro/1.0/Files/file-1/Associations/invoice-1', $transport->requests()[1]->path);
        self::assertTrue($deleted);
    }

    public function test_it_can_get_association_counts_for_objects(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'invoice-1' => 3,
            'invoice-2' => 1,
        ], JSON_THROW_ON_ERROR)));

        $counts = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->associations('file-1')
            ->countFor('invoice-1', 'invoice-2');

        self::assertSame('/files.xro/1.0/Associations/Count', $transport->requests()[0]->path);
        self::assertSame('invoice-1,invoice-2', $transport->requests()[0]->query['ObjectIds']);
        $count = $counts->first();
        self::assertNotNull($count);
        self::assertSame('invoice-1', $count->getObjectId());
        self::assertSame(3, $count->getCount());
    }

    public function test_loaded_file_can_be_deleted(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Id' => 'file-1',
            'Name' => 'contract.pdf',
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $file = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->files()
            ->find('file-1');

        $deleted = $file?->delete();

        self::assertSame('DELETE', $transport->requests()[1]->method);
        self::assertSame('/files.xro/1.0/Files/file-1', $transport->requests()[1]->path);
        self::assertTrue((bool) $deleted);
    }
}
