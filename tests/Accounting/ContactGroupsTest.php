<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Accounting;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Accounting\ContactGroup\ContactGroup;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Support\Json;
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
                'Contacts' => [['ContactID' => 'contact-1', 'Name' => 'Acme Ltd']],
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
        self::assertNotNull($groups->first());
        self::assertSame('/api.xro/2.0/ContactGroups/group-1', $transport->requests()[1]->path);
        self::assertSame('/api.xro/2.0/ContactGroups', $transport->requests()[2]->path);
        self::assertSame('/api.xro/2.0/ContactGroups/group-2', $transport->requests()[3]->path);
        self::assertSame('PUT', $transport->requests()[4]->method);
        self::assertSame('/api.xro/2.0/ContactGroups/group-2/Contacts', $transport->requests()[4]->path);
        $json4 = $transport->requests()[4]->json ?? [];
        $contact4 = Json::extractFirst($json4, 'Contacts');
        self::assertNotNull($contact4);
        self::assertSame('contact-1', $contact4['ContactID']);
        self::assertSame(['contact-1'], $attached->getContactIDs());
        self::assertSame('contact-1', $attached->getContacts()[0]->getContactID());
        self::assertSame('Acme Ltd', $attached->getContacts()[0]->getName());
        self::assertSame('group-1', $group?->getContactGroupID());
    }

    public function test_it_updates_via_builder_and_exposes_helpers(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-2',
                'Name' => 'Partners',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $contactGroups = Xero::withAccessToken('token', $transport)->tenant('tenant-123')->accounting()->contactGroups();

        $updated = $contactGroups->update('group-2')
            ->status('ACTIVE')
            ->contact('contact-1')
            ->save();

        self::assertSame('/api.xro/2.0/ContactGroups/group-2', $transport->requests()[0]->path);
        $sent = Json::extractFirst($transport->requests()[0]->json ?? [], 'ContactGroups');
        self::assertNotNull($sent);
        self::assertSame('ACTIVE', $sent['Status'] ?? null);
        self::assertSame('contact-1', Json::extractList($sent, 'Contacts')[0]['ContactID'] ?? null);
        self::assertSame('Partners', $updated->getName());
        self::assertSame('ACTIVE', $updated->getStatus());

        self::assertNotSame([], $contactGroups->scopes()->broad);
        // contacts() returns a ContactAssignments manager (its return type guarantees the class); call it for coverage.
        $contactGroups->contacts('group-2');

        $model = (new ContactGroup())->addContactID('contact-9');
        self::assertSame(['contact-9'], $model->getContactIDs());
    }

    public function test_contact_group_model_save_attaches_contacts(): void
    {
        $body = json_encode([
            'ContactGroups' => [[
                'ContactGroupID' => 'group-3',
                'Name' => 'Team',
                'Status' => 'ACTIVE',
            ]],
        ], JSON_THROW_ON_ERROR);

        $transport = (new FakeTransport())
            ->push(new Response(200, body: $body))
            ->push(new Response(200, body: $body));

        $group = Xero::withAccessToken('token', $transport)->tenant('tenant-123')
            ->accounting()->contactGroups()->get()->first();
        self::assertNotNull($group);

        $saved = $group->addContactID('contact-5')->save();

        self::assertSame('/api.xro/2.0/ContactGroups/group-3', $transport->requests()[1]->path);
        $sent = Json::extractFirst($transport->requests()[1]->json ?? [], 'ContactGroups');
        self::assertNotNull($sent);
        self::assertSame('contact-5', Json::extractList($sent, 'Contacts')[0]['ContactID'] ?? null);
        self::assertSame('Team', $saved->getName());
    }

    public function test_contact_group_model_guards_require_a_client(): void
    {
        $this->expectException(RuntimeException::class);

        (new ContactGroup())->save();
    }

    public function test_contact_group_member_access_requires_a_client_and_id(): void
    {
        $this->expectException(RuntimeException::class);

        (new ContactGroup())->contacts();
    }
}
