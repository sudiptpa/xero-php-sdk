<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

final class AssociationCount
{
    private ?string $objectId = null;

    private ?int $count = null;

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
