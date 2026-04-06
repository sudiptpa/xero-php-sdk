<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\RepeatingInvoice;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class RepeatingInvoice extends Model
{
    private ?string $repeatingInvoiceID = null;

    private ?string $type = null;

    private ?string $status = null;

    private ?string $reference = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getRepeatingInvoiceID(): ?string
    {
        return $this->repeatingInvoiceID;
    }

    public function setRepeatingInvoiceID(?string $repeatingInvoiceID): self
    {
        $this->repeatingInvoiceID = $repeatingInvoiceID;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'RepeatingInvoiceID' => Field::string(),
            'Type' => Field::string(),
            'Status' => Field::string(),
            'Reference' => Field::string(),
        ];
    }

    public function reference(string $reference): self
    {
        return $this->setReference($reference);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a repeating invoice without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->repeatingInvoiceID !== null) {
            $payload = $payload->id($this->repeatingInvoiceID);
        }

        if ($this->type !== null) {
            $payload = $payload->type($this->type);
        }

        if ($this->reference !== null) {
            $payload = $payload->reference($this->reference);
        }

        return $payload->save();
    }
}
