<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\StatutoryLeave;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ScopeRequirements;

final class StatutoryLeaves implements DefinesScopes
{
    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.settings'],
            granular: ['payroll.settings.read', 'payroll.settings']
        );
    }

    public function findSick(string $statutorySickLeaveId): ?EmployeeStatutorySickLeave
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/StatutoryLeaves/Sick/' . $statutorySickLeaveId)
            ->send()
            ->json();

        $leave = Json::extractObject($payload, 'statutorySickLeave');

        return $leave !== [] ? $this->mapSick($leave) : null;
    }

    public function createSick(EmployeeStatutorySickLeave $leave, ?string $idempotencyKey = null): EmployeeStatutorySickLeave
    {
        $payload = $this->client
            ->post('/payroll.xro/2.0/StatutoryLeaves/Sick')
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($leave->toRequest())
            ->send()
            ->json();

        return $this->mapSick(Json::extractObject($payload, 'statutorySickLeave'));
    }

    /**
     * @param array<string, mixed> $leave
     */
    public function mapSick(array $leave): EmployeeStatutorySickLeave
    {
        return (new EmployeeStatutorySickLeave())->fill($leave);
    }
}
