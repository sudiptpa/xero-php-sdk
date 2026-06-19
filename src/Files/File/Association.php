<?php

declare(strict_types=1);

namespace Sujip\Xero\Files\File;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Association extends Model
{
    public function __construct(
        private ?string $fileId = null,
        private ?string $objectId = null,
        private ?string $objectGroup = null,
        private ?string $objectType = null,
        private ?bool $sendWithObject = null,
        private ?string $name = null,
        private int|float|null $size = null,
        private ?string $createdDateUtc = null,
        private ?string $associationDateUtc = null,
    ) {
    }

    public function getFileId(): ?string
    {
        return $this->fileId;
    }

    public function setFileId(?string $fileId): self
    {
        $this->fileId = $fileId;

        return $this;
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

    public function getObjectGroup(): ?string
    {
        return $this->objectGroup;
    }

    public function setObjectGroup(?string $objectGroup): self
    {
        $this->objectGroup = $objectGroup;

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

    public function getSendWithObject(): ?bool
    {
        return $this->sendWithObject;
    }

    public function setSendWithObject(?bool $sendWithObject): self
    {
        $this->sendWithObject = $sendWithObject;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSize(): int|float|null
    {
        return $this->size;
    }

    public function setSize(int|float|null $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getCreatedDateUTC(): ?string
    {
        return $this->createdDateUtc;
    }

    public function setCreatedDateUTC(?string $createdDateUtc): self
    {
        $this->createdDateUtc = $createdDateUtc;

        return $this;
    }

    public function getAssociationDateUTC(): ?string
    {
        return $this->associationDateUtc;
    }

    public function setAssociationDateUTC(?string $associationDateUtc): self
    {
        $this->associationDateUtc = $associationDateUtc;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'FileId' => Field::string()->using('setFileId'),
            'ObjectId' => Field::string()->using('setObjectId'),
            'ObjectGroup' => Field::string()->using('setObjectGroup'),
            'ObjectType' => Field::string()->using('setObjectType'),
            'SendWithObject' => Field::boolean()->using('setSendWithObject'),
            'Name' => Field::string()->using('setName'),
            'Size' => Field::number()->using('setSize'),
            'CreatedDateUtc' => Field::string()->using('setCreatedDateUTC'),
            'AssociationDateUtc' => Field::string()->using('setAssociationDateUTC'),
        ];
    }
}
