<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Report extends Model
{
    private ?string $reportID = null;

    private ?string $reportName = null;

    private ?string $reportType = null;

    private ?string $title = null;

    private ?string $reportTitle = null;

    private ?string $reportDate = null;

    private ?string $updatedDateUTC = null;

    /**
     * @var list<TenNinetyNineContact>
     */
    private array $contacts = [];

    public function getReportID(): ?string
    {
        return $this->reportID;
    }

    public function setReportID(?string $reportID): self
    {
        $this->reportID = $reportID;

        return $this;
    }

    public function getReportName(): ?string
    {
        return $this->reportName;
    }

    public function setReportName(?string $reportName): self
    {
        $this->reportName = $reportName;

        return $this;
    }

    public function getReportType(): ?string
    {
        return $this->reportType;
    }

    public function setReportType(?string $reportType): self
    {
        $this->reportType = $reportType;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReportTitle(): ?string
    {
        return $this->reportTitle;
    }

    public function setReportTitle(?string $reportTitle): self
    {
        $this->reportTitle = $reportTitle;

        return $this;
    }

    public function getReportDate(): ?string
    {
        return $this->reportDate;
    }

    public function setReportDate(?string $reportDate): self
    {
        $this->reportDate = $reportDate;

        return $this;
    }

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

        return $this;
    }

    /**
     * @return list<TenNinetyNineContact>
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

    public function addContact(TenNinetyNineContact $contact): self
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ReportID' => Field::string(),
            'ReportName' => Field::string(),
            'ReportType' => Field::string(),
            'ReportTitle' => Field::string(),
            'ReportDate' => Field::string(),
            'UpdatedDateUTC' => Field::string(),
            'Contacts' => Field::many(TenNinetyNineContact::class),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        $reportTitles = is_array($payload['ReportTitles'] ?? null) ? $payload['ReportTitles'] : [];
        $firstTitle = $reportTitles[0] ?? null;

        return $this->setTitle(is_string($firstTitle) ? $firstTitle : null);
    }

}
