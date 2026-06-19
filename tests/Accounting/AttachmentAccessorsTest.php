<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class AttachmentAccessorsTest extends TestCase
{
    public function test_resources_expose_attachments_at_their_spec_paths(): void
    {
        $transport = new FakeTransport();

        $expectations = [
            ['accounts', '/api.xro/2.0/Accounts/id-1/Attachments'],
            ['bankTransactions', '/api.xro/2.0/BankTransactions/id-1/Attachments'],
            ['bankTransfers', '/api.xro/2.0/BankTransfers/id-1/Attachments'],
            ['contacts', '/api.xro/2.0/Contacts/id-1/Attachments'],
            ['quotes', '/api.xro/2.0/Quotes/id-1/Attachments'],
            ['repeatingInvoices', '/api.xro/2.0/RepeatingInvoices/id-1/Attachments'],
        ];

        for ($i = 0; $i < count($expectations); $i++) {
            $transport->push(new Response(200, body: json_encode([
                'Attachments' => [[
                    'AttachmentID' => 'attachment-1',
                    'FileName' => 'receipt.png',
                    'MimeType' => 'image/png',
                    'IncludeOnline' => true,
                ]],
            ], JSON_THROW_ON_ERROR)));
        }

        $accounting = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting();

        foreach ($expectations as $index => [$method, $path]) {
            $attachments = $accounting->{$method}()->attachments('id-1')->get();

            self::assertSame($path, $transport->requests()[$index]->path);
            $first = $attachments->first();
            self::assertNotNull($first);
            self::assertSame('attachment-1', $first->id);
            self::assertSame('receipt.png', $first->fileName);
            self::assertSame('image/png', $first->mimeType);
            self::assertTrue($first->includeOnline);
        }
    }

    public function test_it_uploads_an_attachment_with_put(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Attachments' => [['AttachmentID' => 'attachment-1', 'FileName' => 'receipt.png']],
        ], JSON_THROW_ON_ERROR)));

        $attachment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->contacts()
            ->attachments('contact-1')
            ->upload('receipt 1.png', 'binary-content')
            ->mimeType('image/png')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('PUT', $request->method);
        self::assertSame('/api.xro/2.0/Contacts/contact-1/Attachments/receipt%201.png', $request->path);
        self::assertSame('binary-content', $request->body);
        self::assertSame('image/png', $request->headers['Content-Type']);
        self::assertSame('attachment-1', $attachment->id);
    }

    public function test_it_updates_an_attachment_with_post(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $attachment = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->accounts()
            ->attachments('account-1')
            ->upload('receipt.png', 'binary-content')
            ->update();

        $request = $transport->requests()[0];
        self::assertSame('POST', $request->method);
        self::assertSame('/api.xro/2.0/Accounts/account-1/Attachments/receipt.png', $request->path);
        self::assertArrayNotHasKey('Content-Type', $request->headers);
        self::assertNull($attachment->id);
    }

    public function test_it_uploads_an_online_attachment(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->bankTransactions()
            ->attachments('txn-1')
            ->upload('receipt.png', 'binary-content')
            ->includeOnline()
            ->save();

        self::assertSame(
            '/api.xro/2.0/BankTransactions/txn-1/Attachments/receipt.png?IncludeOnline=true',
            $transport->requests()[0]->path
        );
    }

    public function test_it_downloads_attachments_by_file_name_and_id(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: 'png-bytes'));
        $transport->push(new Response(200, body: 'pdf-bytes'));

        $attachments = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->accounting()
            ->quotes()
            ->attachments('quote-1');

        self::assertSame('png-bytes', $attachments->download('receipt 1.png', 'image/png'));
        self::assertSame('pdf-bytes', $attachments->downloadById('attachment-1', 'application/pdf'));

        self::assertSame('/api.xro/2.0/Quotes/quote-1/Attachments/receipt%201.png', $transport->requests()[0]->path);
        self::assertSame('image/png', $transport->requests()[0]->headers['Accept']);
        self::assertSame('/api.xro/2.0/Quotes/quote-1/Attachments/attachment-1', $transport->requests()[1]->path);
        self::assertSame('application/pdf', $transport->requests()[1]->headers['Accept']);
    }
}
