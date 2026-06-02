<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Json;

final class AssociationPayload
{
    private const BASE_PATH = '/files.xro/1.0/Files';

    private ?string $objectId = null;

    private ?string $objectType = null;

    private ?string $objectGroup = null;

    public function __construct(
        private readonly Client $client,
        private readonly string $fileId
    ) {
    }

    public function objectId(?string $objectId): self
    {
        $clone = clone $this;
        $clone->objectId = $objectId;

        return $clone;
    }

    public function objectType(?string $objectType): self
    {
        $clone = clone $this;
        $clone->objectType = $objectType;

        return $clone;
    }

    public function objectGroup(?string $objectGroup): self
    {
        $clone = clone $this;
        $clone->objectGroup = $objectGroup;

        return $clone;
    }

    public function save(): Association
    {
        $response = $this->client
            ->post(self::BASE_PATH . '/' . $this->fileId . '/Associations')
            ->withJson(array_filter([
                'ObjectId' => $this->objectId,
                'ObjectType' => $this->objectType,
                'ObjectGroup' => $this->objectGroup,
            ], static fn (?string $value): bool => $value !== null))
            ->send();

        $payload = $response->json();
        $association = Json::extractFirst($payload, 'Items') ?? [];

        return (new Associations($this->client, $this->fileId))
            ->mapAssociation($association);
    }
}
