<?php

declare(strict_types=1);

namespace Sujip\Xero\Projects\Project;

use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Projects\Task\Tasks;
use Sujip\Xero\Projects\TimeEntry\TimeEntries;
use Sujip\Xero\Support\Field;
use Sujip\Xero\Support\Model;

final class Project extends Model
{
    private ?string $projectId = null;

    private ?string $contactId = null;

    private ?string $name = null;

    private ?string $currencyCode = null;

    private ?int $minutesLogged = null;

    private ?Amount $totalTaskAmount = null;

    private ?Amount $totalExpenseAmount = null;

    private ?Amount $estimateAmount = null;

    private ?int $minutesToBeInvoiced = null;

    private ?Amount $taskAmountToBeInvoiced = null;

    private ?Amount $taskAmountInvoiced = null;

    private ?Amount $expenseAmountToBeInvoiced = null;

    private ?Amount $expenseAmountInvoiced = null;

    private ?Amount $projectAmountInvoiced = null;

    private ?Amount $deposit = null;

    private ?Amount $depositApplied = null;

    private ?Amount $creditNoteAmount = null;

    private ?string $deadlineUtc = null;

    private ?Amount $totalInvoiced = null;

    private ?Amount $totalToBeInvoiced = null;

    private ?Amount $estimate = null;

    private ?string $status = null;

    public function __construct(
        private ?Client $client = null
    ) {
    }

    public function getProjectId(): ?string
    {
        return $this->projectId;
    }

    public function setProjectId(?string $projectId): self
    {
        $this->projectId = $projectId;

        return $this;
    }

    public function getContactId(): ?string
    {
        return $this->contactId;
    }

    public function setContactId(?string $contactId): self
    {
        $this->contactId = $contactId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(?string $currencyCode): self
    {
        $this->currencyCode = $currencyCode;

        return $this;
    }

    public function getMinutesLogged(): ?int
    {
        return $this->minutesLogged;
    }

    public function setMinutesLogged(?int $minutesLogged): self
    {
        $this->minutesLogged = $minutesLogged;

        return $this;
    }

    public function getTotalTaskAmount(): ?Amount
    {
        return $this->totalTaskAmount;
    }

    public function setTotalTaskAmount(?Amount $totalTaskAmount): self
    {
        $this->totalTaskAmount = $totalTaskAmount;

        return $this;
    }

    public function getTotalExpenseAmount(): ?Amount
    {
        return $this->totalExpenseAmount;
    }

    public function setTotalExpenseAmount(?Amount $totalExpenseAmount): self
    {
        $this->totalExpenseAmount = $totalExpenseAmount;

        return $this;
    }

    public function getEstimateAmount(): ?Amount
    {
        return $this->estimateAmount;
    }

    public function setEstimateAmount(?Amount $estimateAmount): self
    {
        $this->estimateAmount = $estimateAmount;

        return $this;
    }

    public function getMinutesToBeInvoiced(): ?int
    {
        return $this->minutesToBeInvoiced;
    }

    public function setMinutesToBeInvoiced(?int $minutesToBeInvoiced): self
    {
        $this->minutesToBeInvoiced = $minutesToBeInvoiced;

        return $this;
    }

    public function getTaskAmountToBeInvoiced(): ?Amount
    {
        return $this->taskAmountToBeInvoiced;
    }

    public function setTaskAmountToBeInvoiced(?Amount $taskAmountToBeInvoiced): self
    {
        $this->taskAmountToBeInvoiced = $taskAmountToBeInvoiced;

        return $this;
    }

    public function getTaskAmountInvoiced(): ?Amount
    {
        return $this->taskAmountInvoiced;
    }

    public function setTaskAmountInvoiced(?Amount $taskAmountInvoiced): self
    {
        $this->taskAmountInvoiced = $taskAmountInvoiced;

        return $this;
    }

    public function getExpenseAmountToBeInvoiced(): ?Amount
    {
        return $this->expenseAmountToBeInvoiced;
    }

    public function setExpenseAmountToBeInvoiced(?Amount $expenseAmountToBeInvoiced): self
    {
        $this->expenseAmountToBeInvoiced = $expenseAmountToBeInvoiced;

        return $this;
    }

    public function getExpenseAmountInvoiced(): ?Amount
    {
        return $this->expenseAmountInvoiced;
    }

    public function setExpenseAmountInvoiced(?Amount $expenseAmountInvoiced): self
    {
        $this->expenseAmountInvoiced = $expenseAmountInvoiced;

        return $this;
    }

    public function getProjectAmountInvoiced(): ?Amount
    {
        return $this->projectAmountInvoiced;
    }

    public function setProjectAmountInvoiced(?Amount $projectAmountInvoiced): self
    {
        $this->projectAmountInvoiced = $projectAmountInvoiced;

        return $this;
    }

    public function getDeposit(): ?Amount
    {
        return $this->deposit;
    }

    public function setDeposit(?Amount $deposit): self
    {
        $this->deposit = $deposit;

        return $this;
    }

    public function getDepositApplied(): ?Amount
    {
        return $this->depositApplied;
    }

    public function setDepositApplied(?Amount $depositApplied): self
    {
        $this->depositApplied = $depositApplied;

        return $this;
    }

    public function getCreditNoteAmount(): ?Amount
    {
        return $this->creditNoteAmount;
    }

    public function setCreditNoteAmount(?Amount $creditNoteAmount): self
    {
        $this->creditNoteAmount = $creditNoteAmount;

        return $this;
    }

    public function getDeadlineUtc(): ?string
    {
        return $this->deadlineUtc;
    }

    public function setDeadlineUtc(?string $deadlineUtc): self
    {
        $this->deadlineUtc = $deadlineUtc;

        return $this;
    }

    public function getTotalInvoiced(): ?Amount
    {
        return $this->totalInvoiced;
    }

    public function setTotalInvoiced(?Amount $totalInvoiced): self
    {
        $this->totalInvoiced = $totalInvoiced;

        return $this;
    }

    public function getTotalToBeInvoiced(): ?Amount
    {
        return $this->totalToBeInvoiced;
    }

    public function setTotalToBeInvoiced(?Amount $totalToBeInvoiced): self
    {
        $this->totalToBeInvoiced = $totalToBeInvoiced;

        return $this;
    }

    public function getEstimate(): ?Amount
    {
        return $this->estimate;
    }

    public function setEstimate(?Amount $estimate): self
    {
        $this->estimate = $estimate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status === null ? null : strtoupper($status);

        return $this;
    }

    /**
     * @return array<string, Field>
     */
    protected static function getDefinitions(): array
    {
        return [
            'projectId' => Field::string(),
            'contactId' => Field::string(),
            'name' => Field::string(),
            'currencyCode' => Field::string(),
            'minutesLogged' => Field::number(),
            'totalTaskAmount' => Field::object(Amount::class),
            'totalExpenseAmount' => Field::object(Amount::class),
            'estimateAmount' => Field::object(Amount::class),
            'minutesToBeInvoiced' => Field::number(),
            'taskAmountToBeInvoiced' => Field::object(Amount::class),
            'taskAmountInvoiced' => Field::object(Amount::class),
            'expenseAmountToBeInvoiced' => Field::object(Amount::class),
            'expenseAmountInvoiced' => Field::object(Amount::class),
            'projectAmountInvoiced' => Field::object(Amount::class),
            'deposit' => Field::object(Amount::class),
            'depositApplied' => Field::object(Amount::class),
            'creditNoteAmount' => Field::object(Amount::class),
            'deadlineUtc' => Field::string(),
            'totalInvoiced' => Field::object(Amount::class),
            'totalToBeInvoiced' => Field::object(Amount::class),
            'estimate' => Field::object(Amount::class),
            'status' => Field::string(),
        ];
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function status(string $status): self
    {
        return $this->setStatus($status);
    }

    public function deadline(string $deadlineUtc): self
    {
        return $this->setDeadlineUtc($deadlineUtc);
    }

    public function save(): self
    {
        if ($this->client === null) {
            throw new RuntimeException('Cannot save a project without a bound client context.');
        }

        $payload = new Payload($this->client);

        if ($this->projectId !== null) {
            $payload = $payload->id($this->projectId);
        }

        if ($this->name !== null) {
            $payload = $payload->title($this->name);
        }

        if ($this->contactId !== null) {
            $payload = $payload->contact($this->contactId);
        }

        if ($this->deadlineUtc !== null) {
            $payload = $payload->deadline($this->deadlineUtc);
        }

        return $payload->save();
    }

    public function tasks(): Tasks
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot access project tasks without a bound client context and project id.');
        }

        return new Tasks($this->client, $this->projectId);
    }

    public function timeEntries(): TimeEntries
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot access project time entries without a bound client context and project id.');
        }

        return new TimeEntries($this->client, $this->projectId);
    }

    public function close(): self
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot close a project without a bound client context and project id.');
        }

        return (new Projects($this->client))->patch($this->projectId)->close()->save();
    }

    public function reopen(): self
    {
        if ($this->client === null || $this->projectId === null) {
            throw new RuntimeException('Cannot reopen a project without a bound client context and project id.');
        }

        return (new Projects($this->client))->patch($this->projectId)->reopen()->save();
    }
}
