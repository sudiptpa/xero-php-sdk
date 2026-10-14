<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Report;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ReportRow extends Model
{
    private ?string $rowType = null;

    private ?string $title = null;

    /**
     * @var list<ReportCell>
     */
    private array $cells = [];

    /**
     * @var list<ReportRow>
     */
    private array $rows = [];

    public function getRowType(): ?string
    {
        return $this->rowType;
    }

    public function setRowType(?string $rowType): self
    {
        $this->rowType = $rowType;

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
     * @return list<ReportCell>
     */
    public function getCells(): array
    {
        return $this->cells;
    }

    public function addCell(ReportCell $cell): self
    {
        $this->cells[] = $cell;

        return $this;
    }

    /**
     * @return list<ReportRow>
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    public function addRow(ReportRow $row): self
    {
        $this->rows[] = $row;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'RowType' => Field::string(),
            'Title' => Field::string(),
            'Cells' => Field::many(ReportCell::class),
            'Rows' => Field::many(ReportRow::class),
        ];
    }
}
