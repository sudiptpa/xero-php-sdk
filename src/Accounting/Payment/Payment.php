<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\Payment;

use Sujip\Xero\Accounting\History;
use RuntimeException;
use Sujip\Xero\Client;

final readonly class Payment
{
    /**
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?float $amount,
        public ?string $date,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        return new self(
            $payload['PaymentID'] ?? null,
            isset($payload['Amount']) ? (float) $payload['Amount'] : null,
            $payload['Date'] ?? null,
            $payload,
            $client
        );
    }

    public function amount(int|float $amount): self
    {
        $payload = $this->raw;
        $payload['Amount'] = $amount;

        return new self($this->id, (float) $amount, $this->date, $payload, $this->client);
    }

    public function date(string $date): self
    {
        $payload = $this->raw;
        $payload['Date'] = $date;

        return new self($this->id, $this->amount, $date, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a payment without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->amount !== null) {
            $payload = $payload->amount($this->amount);
        }

        if ($this->date !== null) {
            $payload = $payload->date($this->date);
        }

        if (isset($this->raw['Reference']) && is_string($this->raw['Reference'])) {
            $payload = $payload->reference($this->raw['Reference']);
        }

        if (isset($this->raw['Invoice']['InvoiceID']) && is_string($this->raw['Invoice']['InvoiceID'])) {
            $payload = $payload->invoice($this->raw['Invoice']['InvoiceID']);
        }

        if (isset($this->raw['Account']['AccountID']) && is_string($this->raw['Account']['AccountID'])) {
            $payload = $payload->account($this->raw['Account']['AccountID']);
        }

        return $payload->save();
    }

    public function history(): History
    {
        if ($this->client === null || $this->id === null) {
            throw new RuntimeException('Cannot access payment history without a bound client context and payment id.');
        }

        return (new Payments($this->client))->history($this->id);
    }
}
