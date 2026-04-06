<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class InvoiceReference extends Model
{
    private ?string $invoiceID = null;

    public function getInvoiceID(): ?string
    {
        return $this->invoiceID;
    }

    public function setInvoiceID(?string $invoiceID): self
    {
        $this->invoiceID = $invoiceID;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'InvoiceID' => Field::string(),
        ];
    }
}
