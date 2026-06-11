<?php

declare(strict_types=1);

namespace Sujip\Xero\Finance\FinancialStatement;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;
use Sujip\Xero\Support\Json;

final class Statement extends Model
{
    /**
     * @param list<array<string, mixed>> $rows
     */
    public function __construct(
        private string $type = '',
        private array $rows = []
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }
    /**
     * @return list<array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->rows;
    }
    /**
     * @param list<array<string, mixed>> $rows
     */
    public function setRows(array $rows): self
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'Type' => Field::string(),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        return $this->setRows(Json::extractList($payload, 'Rows') ?: Json::extractList($payload, 'rows'));
    }
}
