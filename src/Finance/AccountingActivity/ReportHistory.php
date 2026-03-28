<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\AccountingActivity;

final class ReportHistory
{
    public function __construct(
        private ?string $reportName = null,
        private ?string $publishedDateUTC = null,
        private ?string $publishedBy = null
    ) {
    }

    public function getReportName(): ?string { return $this->reportName; }
    public function setReportName(?string $reportName): self { $this->reportName = $reportName; return $this; }
    public function getPublishedDateUTC(): ?string { return $this->publishedDateUTC; }
    public function setPublishedDateUTC(?string $publishedDateUTC): self { $this->publishedDateUTC = $publishedDateUTC; return $this; }
    public function getPublishedBy(): ?string { return $this->publishedBy; }
    public function setPublishedBy(?string $publishedBy): self { $this->publishedBy = $publishedBy; return $this; }
}
