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

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ReportID' => Field::string(),
            'ReportName' => Field::string(),
            'ReportType' => Field::string(),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        return $this->setTitle(
            isset($payload['ReportTitles'][0]) && is_string($payload['ReportTitles'][0])
                ? $payload['ReportTitles'][0]
                : null
        );
    }

}
