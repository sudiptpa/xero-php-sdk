<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PaySlip;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class PaySlips implements DefinesScopes
{
    use HasPagination;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.payslip'],
            granular: ['payroll.payslip.read', 'payroll.payslip']
        );
    }

    /**
     * The API requires the containing pay run to list payslips.
     *
     * @return ResourceCollection<PaySlip>
     */
    public function get(string $payRunId): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/PaySlips')
            ->withQuery(array_merge(['PayRunID' => $payRunId], $this->paginationQuery()))
            ->send()
            ->json();

        $items = array_map(
            fn (array $paySlip): PaySlip => $this->mapPaySlip($paySlip),
            Json::extractList($payload, 'paySlips')
        );

        return new ResourceCollection($items);
    }

    public function find(string $paySlipId): ?PaySlip
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/PaySlips/' . $paySlipId)
            ->send()
            ->json();

        $paySlip = Json::extractObject($payload, 'paySlip');

        return $paySlip !== [] ? $this->mapPaySlip($paySlip) : null;
    }

    public function updateLineItems(string $paySlipId, PaySlip $paySlip, ?string $idempotencyKey = null): PaySlip
    {
        $payload = $this->client
            ->put('/payroll.xro/2.0/PaySlips/' . $paySlipId)
            ->withHeaders($idempotencyKey === null ? [] : ['Idempotency-Key' => $idempotencyKey])
            ->withJson($paySlip->toRequest())
            ->send()
            ->json();

        $updated = Json::extractObject($payload, 'paySlip');

        return $this->mapPaySlip($updated);
    }

    /**
     * @param array<string, mixed> $paySlip
     */
    public function mapPaySlip(array $paySlip): PaySlip
    {
        return (new PaySlip())->fill($paySlip);
    }
}
