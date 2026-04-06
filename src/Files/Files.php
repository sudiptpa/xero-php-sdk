<?php

declare(strict_types=1);

namespace Sujip\Xero\Files;

use Sujip\Xero\Client;
use Sujip\Xero\Files\File\Associations;
use Sujip\Xero\Files\File\File;
use Sujip\Xero\Files\File\Files as FilesResource;
use Sujip\Xero\Files\File\ObjectAssociations;
use Sujip\Xero\Files\File\Payload as FilePayload;
use Sujip\Xero\Files\File\Upload;
use Sujip\Xero\Files\Folder\Folder;
use Sujip\Xero\Files\Folder\Folders as FoldersResource;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class Files implements DefinesScopes
{
    private FilesResource $files;

    public function __construct(
        private Client $client
    ) {
        $this->files = new FilesResource($client);
    }

    public function files(): FilesResource
    {
        return $this->files;
    }

    public function scopes(): ScopeRequirements
    {
        return $this->files()->scopes();
    }

    public function page(int $page): self
    {
        $clone = clone $this;
        $clone->files = $this->files->page($page);

        return $clone;
    }

    public function perPage(int $perPage): self
    {
        $clone = clone $this;
        $clone->files = $this->files->perPage($perPage);

        return $clone;
    }

    public function orderBy(string $field, string $direction = 'ASC'): self
    {
        $clone = clone $this;
        $clone->files = $this->files->orderBy($field, $direction);

        return $clone;
    }

    /**
     * @return ResourceCollection<File>
     */
    public function get(): ResourceCollection
    {
        return $this->files()->get();
    }

    /**
     * @return PaginatedCollection<File>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        return $this->files()->paginate($page, $perPage);
    }

    public function find(string $fileId): ?File
    {
        return $this->files()->find($fileId);
    }

    public function content(string $fileId): string
    {
        return $this->files()->content($fileId);
    }

    public function delete(string $fileId): bool
    {
        return $this->files()->delete($fileId);
    }

    public function upload(string $name, string $content, ?string $filename = null): Upload
    {
        return $this->files()->upload($name, $content, $filename);
    }

    public function update(string $fileId): FilePayload
    {
        return $this->files()->update($fileId);
    }

    public function associations(string $fileId): Associations
    {
        return $this->files()->associations($fileId);
    }

    public function forObject(string $objectId): ObjectAssociations
    {
        return $this->files()->forObject($objectId);
    }

    public function folders(): FoldersResource
    {
        return new FoldersResource($this->client);
    }

    public function findFolder(string $folderId): ?Folder
    {
        return $this->folders()->find($folderId);
    }

    public function client(): Client
    {
        return $this->client;
    }
}
