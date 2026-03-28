<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayRun;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

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
            ->get('/payroll.xro/1.0/PayRuns/' . $this->payRunId . '/Payslips')
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $payslip): Payslip => $this->mapPayslip($payslip),
            $payload['Payslips'] ?? []
        ));

        return new ResourceCollection($items);
    }

    public function find(string $payslipId): ?Payslip
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/PayRuns/' . $this->payRunId . '/Payslips/' . $payslipId)
            ->send()
            ->json();

        $payslip = $payload['Payslips'][0] ?? $payload['Payslip'] ?? null;

        return is_array($payslip) ? $this->mapPayslip($payslip) : null;
    }

    /**
     * @param array<string, mixed> $payslip
     */
    public function mapPayslip(array $payslip): Payslip
    {
        return (new Payslip())
            ->setPayslipID($payslip['PayslipID'] ?? null)
            ->setEmployeeID($payslip['EmployeeID'] ?? null)
            ->setPaymentDate($payslip['PaymentDate'] ?? null)
            ->setNetPay(isset($payslip['NetPay']) ? (string) $payslip['NetPay'] : null)
            ;
    }
}
