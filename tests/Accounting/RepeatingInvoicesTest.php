<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Accounting\Invoice\LineItem;
use Sujip\Xero\Accounting\RepeatingInvoice\RepeatingInvoice;
use Sujip\Xero\Accounting\RepeatingInvoice\Schedule;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\AttachmentDetail;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class RepeatingInvoicesTest extends TestCase
{
    public function test_it_can_query_and_find_repeating_invoices(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Type' => 'ACCREC',
                'Status' => 'DRAFT',
                'Reference' => 'RI-1001',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'ID' => 'guid-1',
                'Type' => 'ACCREC',
                'Contact' => ['ContactID' => 'contact-1'],
                'Schedule' => [
                    'Period' => 1,
                    'Unit' => 'MONTHLY',
                    'DueDate' => 10,
                    'DueDateType' => 'DAYSAFTERBILLDATE',
                    'StartDate' => '2026-01-01T00:00:00',
                    'NextScheduledDate' => '2026-07-01T00:00:00',
                    'EndDate' => '2027-01-01T00:00:00',
                ],
                'LineItems' => [['Description' => 'Monthly support', 'Quantity' => 1, 'UnitAmount' => 99]],
                'LineAmountTypes' => 'Exclusive',
                'Status' => 'AUTHORISED',
                'BrandingThemeID' => 'brand-1',
                'CurrencyCode' => 'NZD',
                'SubTotal' => 99,
                'TotalTax' => 0,
                'Total' => 99,
                'HasAttachments' => true,
                'Attachments' => [['AttachmentID' => 'attach-1', 'FileName' => 'invoice.pdf']],
                'ApprovedForSending' => true,
                'SendCopy' => false,
                'MarkAsSent' => true,
                'IncludePDF' => false,
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $repeatingInvoices = $client->accounting()->repeatingInvoices()->where('Status == :status', status: 'DRAFT')->get();
        $repeatingInvoice = $client->accounting()->repeatingInvoices()->find('repeat-1');

        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[0]->path);
        self::assertNotNull($repeatingInvoices->first());
        self::assertSame('ACCREC', $repeatingInvoices->first()->getType());
        self::assertSame('DRAFT', $repeatingInvoices->first()->getStatus());
        self::assertSame('/api.xro/2.0/RepeatingInvoices/repeat-1', $transport->requests()[1]->path);
        self::assertNotNull($repeatingInvoice);
        self::assertSame('repeat-1', $repeatingInvoice->getRepeatingInvoiceID());
        self::assertSame('guid-1', $repeatingInvoice->getID());
        self::assertSame('contact-1', $repeatingInvoice->getContact()?->getContactID());
        self::assertSame('MONTHLY', $repeatingInvoice->getSchedule()?->getUnit());
        self::assertSame(1, $repeatingInvoice->getSchedule()->getPeriod());
        self::assertSame(10, $repeatingInvoice->getSchedule()->getDueDate());
        self::assertSame('DAYSAFTERBILLDATE', $repeatingInvoice->getSchedule()->getDueDateType());
        self::assertSame('2026-01-01T00:00:00', $repeatingInvoice->getSchedule()->getStartDate());
        self::assertSame('2026-07-01T00:00:00', $repeatingInvoice->getSchedule()->getNextScheduledDate());
        self::assertSame('2027-01-01T00:00:00', $repeatingInvoice->getSchedule()->getEndDate());
        self::assertCount(1, $repeatingInvoice->getLineItems());
        self::assertSame('Monthly support', $repeatingInvoice->getLineItems()[0]->getDescription());
        self::assertSame('Exclusive', $repeatingInvoice->getLineAmountTypes());
        self::assertSame('AUTHORISED', $repeatingInvoice->getStatus());
        self::assertSame('brand-1', $repeatingInvoice->getBrandingThemeID());
        self::assertSame('NZD', $repeatingInvoice->getCurrencyCode());
        self::assertSame(99, $repeatingInvoice->getSubTotal());
        self::assertSame(0, $repeatingInvoice->getTotalTax());
        self::assertSame(99, $repeatingInvoice->getTotal());
        self::assertTrue($repeatingInvoice->getHasAttachments());
        self::assertCount(1, $repeatingInvoice->getAttachments());
        self::assertSame('attach-1', $repeatingInvoice->getAttachments()[0]->getAttachmentID());
        self::assertTrue($repeatingInvoice->getApprovedForSending());
        self::assertFalse($repeatingInvoice->getSendCopy());
        self::assertTrue($repeatingInvoice->getMarkAsSent());
        self::assertFalse($repeatingInvoice->getIncludePDF());
        self::assertNotSame([], $client->accounting()->repeatingInvoices()->scopes()->broad);
    }

    public function test_repeating_invoice_setters_compose_a_model(): void
    {
        $repeatingInvoice = (new RepeatingInvoice())
            ->setRepeatingInvoiceID('repeat-1')
            ->setID('guid-1')
            ->setSchedule((new Schedule())
                ->setPeriod(1)
                ->setUnit('MONTHLY')
                ->setDueDate(10)
                ->setDueDateType('DAYSAFTERBILLDATE')
                ->setStartDate('2026-01-01T00:00:00')
                ->setNextScheduledDate('2026-07-01T00:00:00')
                ->setEndDate('2027-01-01T00:00:00'))
            ->setLineAmountTypes('Exclusive')
            ->setBrandingThemeID('brand-1')
            ->setCurrencyCode('NZD')
            ->setSubTotal(99)
            ->setTotalTax(0)
            ->setTotal(99)
            ->setHasAttachments(true)
            ->setApprovedForSending(true)
            ->setSendCopy(false)
            ->setMarkAsSent(true)
            ->setIncludePDF(false);

        $repeatingInvoice->addAttachment((new AttachmentDetail())->setAttachmentID('attach-1'));
        $repeatingInvoice->setLineItems([(new LineItem())->setDescription('First')]);
        $repeatingInvoice->setLineItems([(new LineItem())->setDescription('Second')]);

        self::assertSame('guid-1', $repeatingInvoice->getID());
        self::assertSame('MONTHLY', $repeatingInvoice->getSchedule()?->getUnit());
        self::assertSame(10, $repeatingInvoice->getSchedule()->getDueDate());
        self::assertSame('DAYSAFTERBILLDATE', $repeatingInvoice->getSchedule()->getDueDateType());
        self::assertSame('2026-01-01T00:00:00', $repeatingInvoice->getSchedule()->getStartDate());
        self::assertSame('2026-07-01T00:00:00', $repeatingInvoice->getSchedule()->getNextScheduledDate());
        self::assertSame('2027-01-01T00:00:00', $repeatingInvoice->getSchedule()->getEndDate());
        self::assertSame('Exclusive', $repeatingInvoice->getLineAmountTypes());
        self::assertSame('brand-1', $repeatingInvoice->getBrandingThemeID());
        self::assertSame('NZD', $repeatingInvoice->getCurrencyCode());
        self::assertSame(99, $repeatingInvoice->getSubTotal());
        self::assertSame(0, $repeatingInvoice->getTotalTax());
        self::assertSame(99, $repeatingInvoice->getTotal());
        self::assertTrue($repeatingInvoice->getHasAttachments());
        self::assertTrue($repeatingInvoice->getApprovedForSending());
        self::assertFalse($repeatingInvoice->getSendCopy());
        self::assertTrue($repeatingInvoice->getMarkAsSent());
        self::assertFalse($repeatingInvoice->getIncludePDF());
        self::assertCount(1, $repeatingInvoice->getAttachments());
        self::assertSame('attach-1', $repeatingInvoice->getAttachments()[0]->getAttachmentID());
        self::assertCount(1, $repeatingInvoice->getLineItems());
        self::assertSame('Second', $repeatingInvoice->getLineItems()[0]->getDescription());
    }

    public function test_it_can_create_and_update_repeating_invoices(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Reference' => 'RI-1001',
                'Type' => 'ACCREC',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Reference' => 'RI-1002',
                'Type' => 'ACCREC',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'RepeatingInvoices' => [[
                'RepeatingInvoiceID' => 'repeat-1',
                'Reference' => 'RI-1003',
                'Type' => 'ACCREC',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $created = $client->accounting()->repeatingInvoices()->create()
            ->type('ACCREC')
            ->contact('contact-1')
            ->reference('RI-1001')
            ->lineItem('Monthly support', 1, 99)
            ->save();

        $updated = $created->reference('RI-1002')->save();

        $client->accounting()->repeatingInvoices()->update('repeat-1')
            ->reference('RI-1003')
            ->save();

        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[0]->path);
        $json0 = $transport->requests()[0]->json ?? [];
        $ri0 = Json::extractFirst($json0, 'RepeatingInvoices');
        self::assertNotNull($ri0);
        self::assertSame('contact-1', Json::extractObject($ri0, 'Contact')['ContactID']);
        $json1 = $transport->requests()[1]->json ?? [];
        $ri1 = Json::extractFirst($json1, 'RepeatingInvoices');
        self::assertNotNull($ri1);
        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[1]->path);
        self::assertSame('repeat-1', $ri1['RepeatingInvoiceID']);
        self::assertSame('RI-1002', $updated->getReference());
        self::assertSame('/api.xro/2.0/RepeatingInvoices', $transport->requests()[2]->path);
        $ri2 = Json::extractFirst($transport->requests()[2]->json ?? [], 'RepeatingInvoices');
        self::assertSame('RI-1003', $ri2['Reference'] ?? null);
    }

    public function test_saving_a_repeating_invoice_without_a_client_throws(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('without a bound client context');

        (new RepeatingInvoice())->reference('RI-9')->save();
    }
}
