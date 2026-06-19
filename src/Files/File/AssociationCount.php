<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

/**
 * Represents one entry of the `/Associations/Count` response, which is a
 * dictionary of object id => association count rather than a modeled schema.
 */
final class AssociationCount
{
    public function __construct(
        private ?string $objectId = null,
        private ?int $count = null,
    ) {
    }

    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    public function setObjectId(?string $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(?int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
