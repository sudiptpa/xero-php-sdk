<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK\PayRun;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final readonly class Payslips implements DefinesScopes
{
    public function __construct(
        private Client $client,
        private string $payRunId
    ) {
    }

    public function scopes(): ScopeRequirements
    {
        return new ScopeRequirements(
            broad: ['payroll.payruns'],
            granular: ['payroll.payruns.read', 'payroll.payruns']
        );
    }

    /**
     * @return ResourceCollection<Payslip>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Payslips')
            ->withQuery(['PayRunID' => $this->payRunId])
            ->send()
            ->json();

        $items = array_map(
            fn (array $payslip): Payslip => $this->mapPayslip($payslip),
            Json::extractList($payload, 'paySlips')
        );

        return new ResourceCollection($items);
    }

    public function find(string $payslipId): ?Payslip
    {
        $payload = $this->client
            ->get('/payroll.xro/2.0/Payslips/' . $payslipId)
            ->send()
            ->json();

        $payslip = Json::extractFirst($payload, 'paySlips') ?? Json::extractObject($payload, 'paySlip') ?: null;

        return $payslip !== null ? $this->mapPayslip($payslip) : null;
    }

    /**
     * @param array<string, mixed> $payslip
     */
    public function mapPayslip(array $payslip): Payslip
    {
        return (new Payslip())->fill($payslip);
    }
}
