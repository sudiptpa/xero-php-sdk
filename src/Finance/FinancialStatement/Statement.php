<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

final class Statement
{
    /**
     * @param list<array<string, mixed>> $rows
     */
    public function __construct(
        private string $type = '',
        private array $rows = []
    ) {
    }

    public function getType(): string { return $this->type; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    /**
     * @return list<array<string, mixed>>
     */
    public function getRows(): array { return $this->rows; }
    /**
     * @param list<array<string, mixed>> $rows
     */
    public function setRows(array $rows): self { $this->rows = $rows; return $this; }
}
