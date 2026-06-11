<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ContactGroup;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

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
        $contactGroup = Json::extractFirst($payload, 'ContactGroups') ?? Json::extractObject($payload, 'ContactGroup');

        return (new ContactGroups($this->client))
            ->mapContactGroup($contactGroup);
    }

    public function remove(string $contactId): bool
    {
        $response = $this->client
            ->delete('/api.xro/2.0/ContactGroups/' . $this->contactGroupId . '/Contacts/' . $contactId)
            ->send();

        return $response->status === 204;
    }
}
