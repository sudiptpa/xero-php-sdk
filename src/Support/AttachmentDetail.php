<?php

declare(strict_types=1);

namespace Sujip\Xero\Support;

final class AttachmentDetail extends Model
{
    private ?string $attachmentID = null;

    private ?string $fileName = null;

    private ?string $url = null;

    private ?string $mimeType = null;

    private ?int $contentLength = null;

    private ?bool $includeOnline = null;

    public function getAttachmentID(): ?string
    {
        return $this->attachmentID;
    }

    public function setAttachmentID(?string $attachmentID): self
    {
        $this->attachmentID = $attachmentID;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(?string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getContentLength(): ?int
    {
        return $this->contentLength;
    }

    public function setContentLength(?int $contentLength): self
    {
        $this->contentLength = $contentLength;

        return $this;
    }

    public function getIncludeOnline(): ?bool
    {
        return $this->includeOnline;
    }

    public function setIncludeOnline(?bool $includeOnline): self
    {
        $this->includeOnline = $includeOnline;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'AttachmentID' => Field::string(),
            'FileName' => Field::string(),
            'Url' => Field::string(),
            'MimeType' => Field::string(),
            'ContentLength' => Field::number(),
            'IncludeOnline' => Field::boolean(),
        ];
    }
}
