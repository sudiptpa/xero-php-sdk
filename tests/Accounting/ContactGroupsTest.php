<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Accounting\ContactGroup\ContactGroup;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ContactGroupsTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_attach_contacts_to_groups(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-1',
                'Name' => 'VIP',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-1',
                'Name' => 'VIP',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-2',
                'Name' => 'Partners',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-2',
                'Name' => 'Strategic Partners',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-2',
                'Name' => 'Strategic Partners',
                'Status' => 'ACTIVE',
                'Contacts' => [['ContactID' => 'contact-1']],
            ]],
        ], JSON_THROW_ON_ERROR)));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $groups = $client->accounting()->contactGroups()->where('Status == :status', status: 'ACTIVE')->get();
        $group = $client->accounting()->contactGroups()->find('group-1');
        $created = $client->accounting()->contactGroups()->create()->name('Partners')->save();
        $updated = $created->name('Strategic Partners')->save();
        $attached = $updated->attachContacts('contact-1');

        self::assertSame('/api.xro/2.0/ContactGroups', $transport->requests()[0]->path);
        self::assertSame('Status == "ACTIVE"', $transport->requests()[0]->query['where']);
        self::assertInstanceOf(ContactGroup::class, $groups->first());
        self::assertSame('/api.xro/2.0/ContactGroups/group-1', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/ContactGroups', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/ContactGroups/group-2', $transport->requests()[3]->path);
        self::assertSame('/api.xro/2.0/ContactGroups/group-2/Contacts', $transport->requests()[4]->path);
        self::assertSame('contact-1', $transport->requests()[4]->json['Contacts'][0]['ContactID']);
        self::assertSame(['contact-1'], $attached->contactIds);
        self::assertSame('group-1', $group?->id);
    }
}
