<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ContactGroup;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $contactGroupId = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $contactGroupId): self
    {
        $clone = clone $this;
        $clone->contactGroupId = $contactGroupId;

        return $clone;
    }

    public function name(string $name): self
    {
        $clone = clone $this;
        $clone->payload['Name'] = $name;

        return $clone;
    }

    public function status(string $status): self
    {
        $clone = clone $this;
        $clone->payload['Status'] = $status;

        return $clone;
    }

    public function contact(string $contactId): self
    {
        $clone = clone $this;
        $contacts = is_array($clone->payload['Contacts'] ?? null) ? $clone->payload['Contacts'] : [];
        $contacts[] = ['ContactID' => $contactId];
        $clone->payload['Contacts'] = $contacts;

        return $clone;
    }

    public function save(): ContactGroup
    {
        $path = '/api.xro/2.0/ContactGroups';

        if ($this->contactGroupId !== null) {
            $path .= '/' . $this->contactGroupId;
        }

        $response = $this->client
            ->post($path)
            ->withJson(['ContactGroups' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $contactGroup = Json::extractFirst($payload, 'ContactGroups') ?? Json::extractObject($payload, 'ContactGroup');

        return (new ContactGroups($this->client))
            ->mapContactGroup($contactGroup);
    }
}
