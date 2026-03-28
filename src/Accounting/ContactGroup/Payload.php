<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ContactGroup;

use Sujip\Xero\Client;

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
        $clone->payload['Contacts'] ??= [];
        $clone->payload['Contacts'][] = ['ContactID' => $contactId];

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
        $contactGroup = $payload['ContactGroups'][0] ?? $payload['ContactGroup'] ?? [];

        return (new ContactGroups($this->client))
            ->mapContactGroup(is_array($contactGroup) ? $contactGroup : []);
    }
}
