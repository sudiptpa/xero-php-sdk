<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ExpenseClaim;

use RuntimeException;
use Sujip\Xero\Client;

final readonly class ExpenseClaim
{
    /**
     * @param list<string> $receiptIds
     * @param array<string, mixed> $raw
     */
    public function __construct(
        public ?string $id,
        public ?string $status,
        public ?string $employeeId,
        public array $receiptIds = [],
        public int|float|null $total = null,
        public array $raw = [],
        private ?Client $client = null
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload, ?Client $client = null): self
    {
        $receiptIds = [];

        foreach (($payload['Receipts'] ?? []) as $receipt) {
            if (is_array($receipt) && isset($receipt['ReceiptID']) && is_string($receipt['ReceiptID'])) {
                $receiptIds[] = $receipt['ReceiptID'];
            }
        }

        return new self(
            $payload['ExpenseClaimID'] ?? null,
            $payload['Status'] ?? null,
            $payload['User']['UserID'] ?? $payload['Employee']['EmployeeID'] ?? null,
            $receiptIds,
            $payload['Total'] ?? null,
            $payload,
            $client
        );
    }

    public function status(string $status): self
    {
        $payload = $this->raw;
        $payload['Status'] = $status;

        return new self($this->id, $status, $this->employeeId, $this->receiptIds, $this->total, $payload, $this->client);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an expense claim without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->id !== null) {
            $payload = $payload->id($this->id);
        }

        if ($this->status !== null) {
            $payload = $payload->status($this->status);
        }

        if ($this->employeeId !== null) {
            $payload = $payload->employee($this->employeeId);
        }

        foreach ($this->receiptIds as $receiptId) {
            $payload = $payload->receipt($receiptId);
        }

        return $payload->save();
    }
}
