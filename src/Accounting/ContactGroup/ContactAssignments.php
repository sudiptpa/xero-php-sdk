<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ContactGroup;

use Sujip\Xero\Client;

final readonly class ContactAssignments
{
    public function __construct(
        private Client $client,
        private string $contactGroupId
    ) {
    }

    public function attach(string ...$contactIds): ContactGroup
    {
        $response = $this->client
            ->post('/api.xro/2.0/ContactGroups/' . $this->contactGroupId . '/Contacts')
            ->withJson([
                'Contacts' => array_map(
                    static fn (string $contactId): array => ['ContactID' => $contactId],
                    $contactIds
                ),
            ])
            ->send();

        $payload = $response->json();
        $contactGroup = $payload['ContactGroups'][0] ?? $payload['ContactGroup'] ?? [];

        return ContactGroup::fromArray(is_array($contactGroup) ? $contactGroup : [], $this->client);
    }
}
