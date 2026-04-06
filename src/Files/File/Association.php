<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Association extends Model
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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ObjectId' => Field::string(),
            'ObjectType' => Field::string(),
            'ObjectGroup' => Field::string(),
        ];
    }

}
