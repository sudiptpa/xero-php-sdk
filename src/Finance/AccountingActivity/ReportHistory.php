<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ReportHistory extends Model
{
    public function __construct(
        private ?string $reportName = null,
        private ?string $publishedDateUTC = null,
        private ?string $publishedBy = null
    ) {
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
    public function getPublishedDateUTC(): ?string
    {
        return $this->publishedDateUTC;
    }
    public function setPublishedDateUTC(?string $publishedDateUTC): self
    {
        $this->publishedDateUTC = $publishedDateUTC;
        return $this;
    }
    public function getPublishedBy(): ?string
    {
        return $this->publishedBy;
    }
    public function setPublishedBy(?string $publishedBy): self
    {
        $this->publishedBy = $publishedBy;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ReportName' => Field::string()->using('setReportName'),
            'PublishedDateUTC' => Field::string()->using('setPublishedDateUTC'),
            'PublishedBy' => Field::string()->using('setPublishedBy'),
        ];
    }
}
