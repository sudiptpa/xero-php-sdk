<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class AssociationCount extends Model
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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ObjectId' => Field::string(),
            'Count' => Field::number(),
        ];
    }

}
