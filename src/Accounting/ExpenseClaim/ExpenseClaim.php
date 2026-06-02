<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ExpenseClaim;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class ExpenseClaim extends Model
{
    private ?string $expenseClaimID = null;

    private ?string $status = null;

    private ?string $employeeID = null;

    /**
     * @var list<string>
     */
    private array $receiptIDs = [];

    private int|float|null $total = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getExpenseClaimID(): ?string
    {
        return $this->expenseClaimID;
    }

    public function setExpenseClaimID(?string $expenseClaimID): self
    {
        $this->expenseClaimID = $expenseClaimID;

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

    public function getEmployeeID(): ?string
    {
        return $this->employeeID;
    }

    public function setEmployeeID(?string $employeeID): self
    {
        $this->employeeID = $employeeID;

        return $this;
    }

    /**
     * @return list<string>
     */
    public function getReceiptIDs(): array
    {
        return $this->receiptIDs;
    }

    /**
     * @param list<string> $receiptIDs
     */
    public function setReceiptIDs(array $receiptIDs): self
    {
        $this->receiptIDs = $receiptIDs;

        return $this;
    }

    public function addReceiptID(string $receiptID): self
    {
        $this->receiptIDs[] = $receiptID;

        return $this;
    }

    public function getTotal(): int|float|null
    {
        return $this->total;
    }

    public function setTotal(int|float|null $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'ExpenseClaimID' => Field::string(),
            'Status' => Field::string(),
            'Total' => Field::number(),
        ];
    }

    public function fill(array $payload): static
    {
        parent::fill($payload);

        $user = is_array($payload['User'] ?? null) ? $payload['User'] : [];
        $employee = is_array($payload['Employee'] ?? null) ? $payload['Employee'] : [];
        $this->setEmployeeID(
            isset($user['UserID']) && is_string($user['UserID'])
                ? $user['UserID']
                : (isset($employee['EmployeeID']) && is_string($employee['EmployeeID'])
                    ? $employee['EmployeeID']
                    : null)
        );

        $receiptIds = [];

        foreach (is_array($payload['Receipts'] ?? null) ? $payload['Receipts'] : [] as $receipt) {
            if (is_array($receipt) && isset($receipt['ReceiptID']) && is_string($receipt['ReceiptID'])) {
                $receiptIds[] = $receipt['ReceiptID'];
            }
        }

        return $this->setReceiptIDs($receiptIds);
    }

    public function status(string $status): self
    {
        return $this->setStatus($status);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save an expense claim without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->expenseClaimID !== null) {
            $payload = $payload->id($this->expenseClaimID);
        }

        if ($this->status !== null) {
            $payload = $payload->status($this->status);
        }

        if ($this->employeeID !== null) {
            $payload = $payload->employee($this->employeeID);
        }

        foreach ($this->receiptIDs as $receiptID) {
            $payload = $payload->receipt($receiptID);
        }

        return $payload->save();
    }
}
