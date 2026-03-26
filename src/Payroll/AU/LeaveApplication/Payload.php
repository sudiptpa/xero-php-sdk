<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\LeaveApplication;

use Sujip\Xero\Client;

final class Payload
{
    /**
     * @var array<string, mixed>
     */
    private array $payload = [];

    private ?string $leaveApplicationId = null;

    private ?string $idempotencyKey = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function id(string $leaveApplicationId): self
    {
        $clone = clone $this;
        $clone->leaveApplicationId = $leaveApplicationId;

        return $clone;
    }

    public function employee(string $employeeId): self
    {
        $clone = clone $this;
        $clone->payload['EmployeeID'] = $employeeId;

        return $clone;
    }

    public function leaveType(string $leaveTypeId): self
    {
        $clone = clone $this;
        $clone->payload['LeaveTypeID'] = $leaveTypeId;

        return $clone;
    }

    public function title(string $title): self
    {
        $clone = clone $this;
        $clone->payload['Title'] = $title;

        return $clone;
    }

    public function startDate(string $startDate): self
    {
        $clone = clone $this;
        $clone->payload['StartDate'] = $startDate;

        return $clone;
    }

    public function endDate(string $endDate): self
    {
        $clone = clone $this;
        $clone->payload['EndDate'] = $endDate;

        return $clone;
    }

    public function idempotencyKey(string $key): self
    {
        $clone = clone $this;
        $clone->idempotencyKey = $key;

        return $clone;
    }

    public function save(): LeaveApplication
    {
        $request = $this->leaveApplicationId === null
            ? $this->client->post('/payroll.xro/1.0/LeaveApplications')
            : $this->client->post('/payroll.xro/1.0/LeaveApplications/' . $this->leaveApplicationId);

        if ($this->leaveApplicationId !== null) {
            $this->payload['LeaveApplicationID'] = $this->leaveApplicationId;
        }

        $response = $request
            ->withHeaders($this->idempotencyKey === null ? [] : ['Idempotency-Key' => $this->idempotencyKey])
            ->withJson(['LeaveApplications' => [$this->payload]])
            ->send();

        $payload = $response->json();
        $leaveApplication = $payload['LeaveApplications'][0] ?? $payload['LeaveApplication'] ?? [];

        return LeaveApplication::fromArray(is_array($leaveApplication) ? $leaveApplication : [], $this->client);
    }
}
