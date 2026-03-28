<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

final class Association
{
    private ?string $objectId = null;

    private ?string $objectType = null;

    private ?string $objectGroup = null;

    public function getObjectId(): ?string
    {
        return $this->objectId;
    }

    public function setObjectId(?string $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getObjectType(): ?string
    {
        return $this->objectType;
    }

    public function setObjectType(?string $objectType): self
    {
        $this->objectType = $objectType;

        return $this;
    }

    public function getObjectGroup(): ?string
    {
        return $this->objectGroup;
    }

    public function setObjectGroup(?string $objectGroup): self
    {
        $this->objectGroup = $objectGroup;

        return $this;
    }

}
