<?php

declare(strict_types=1);

namespace Sujip\Xero\Accounting\ExpenseClaim;

use RuntimeException;
use Sujip\Xero\Accounting\Payment\Payment;
use Sujip\Xero\Accounting\Receipt\Receipt;
use Sujip\Xero\Accounting\User\User;
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

    private int|float|null $amountDue = null;

    private int|float|null $amountPaid = null;

    private ?string $paymentDueDate = null;

    private ?string $reportingDate = null;

    private ?string $updatedDateUTC = null;

    private ?string $receiptID = null;

    private ?User $user = null;

    /**
     * @var list<Payment>
     */
    private array $payments = [];

    /**
     * @var list<Receipt>
     */
    private array $receipts = [];

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

    public function getAmountDue(): int|float|null
    {
        return $this->amountDue;
    }

    public function setAmountDue(int|float|null $amountDue): self
    {
        $this->amountDue = $amountDue;

        return $this;
    }

    public function getAmountPaid(): int|float|null
    {
        return $this->amountPaid;
    }

    public function setAmountPaid(int|float|null $amountPaid): self
    {
        $this->amountPaid = $amountPaid;

        return $this;
    }

    public function getPaymentDueDate(): ?string
    {
        return $this->paymentDueDate;
    }

    public function setPaymentDueDate(?string $paymentDueDate): self
    {
        $this->paymentDueDate = $paymentDueDate;

        return $this;
    }

    public function getReportingDate(): ?string
    {
        return $this->reportingDate;
    }

    public function setReportingDate(?string $reportingDate): self
    {
        $this->reportingDate = $reportingDate;

        return $this;
    }

    public function getUpdatedDateUTC(): ?string
    {
        return $this->updatedDateUTC;
    }

    public function setUpdatedDateUTC(?string $updatedDateUTC): self
    {
        $this->updatedDateUTC = $updatedDateUTC;

        return $this;
    }

    public function getReceiptID(): ?string
    {
        return $this->receiptID;
    }

    public function setReceiptID(?string $receiptID): self
    {
        $this->receiptID = $receiptID;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return list<Payment>
     */
    public function getPayments(): array
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): self
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * @return list<Receipt>
     */
    public function getReceipts(): array
    {
        return $this->receipts;
    }

    public function addReceipt(Receipt $receipt): self
    {
        $this->receipts[] = $receipt;

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
            'AmountDue' => Field::number(),
            'AmountPaid' => Field::number(),
            'PaymentDueDate' => Field::string(),
            'ReportingDate' => Field::string(),
            'UpdatedDateUTC' => Field::string(),
            'ReceiptID' => Field::string(),
            'User' => Field::object(User::class),
            'Payments' => Field::many(Payment::class),
            'Receipts' => Field::many(Receipt::class),
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
