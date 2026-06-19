<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\UK;

use Sujip\Xero\Payroll\Shared\PayrollRegion;
use Sujip\Xero\Payroll\UK\Employee\Employees;
use Sujip\Xero\Payroll\UK\PayItem\Benefits;
use Sujip\Xero\Payroll\UK\PayItem\Deductions;
use Sujip\Xero\Payroll\UK\PayItem\EarningsOrders;
use Sujip\Xero\Payroll\UK\PayItem\EarningsRates;
use Sujip\Xero\Payroll\UK\PayRun\PayRuns;
use Sujip\Xero\Payroll\UK\PayRunCalendar\PayRunCalendars;
use Sujip\Xero\Payroll\UK\Settings\Settings;
use Sujip\Xero\Payroll\UK\StatutoryLeave\StatutoryLeaves;
use Sujip\Xero\Payroll\UK\Timesheet\Timesheets;

final readonly class PayrollUK extends PayrollRegion
{
    public function employees(): Employees
    {
        return new Employees($this->client);
    }

    public function benefits(): Benefits
    {
        return new Benefits($this->client);
    }

    public function deductions(): Deductions
    {
        return new Deductions($this->client);
    }

    public function earningsOrders(): EarningsOrders
    {
        return new EarningsOrders($this->client);
    }

    public function earningsRates(): EarningsRates
    {
        return new EarningsRates($this->client);
    }

    public function payRunCalendars(): PayRunCalendars
    {
        return new PayRunCalendars($this->client);
    }

    public function payRuns(): PayRuns
    {
        return new PayRuns($this->client);
    }

    public function timesheets(): Timesheets
    {
        return new Timesheets($this->client);
    }

    public function settings(): Settings
    {
        return new Settings($this->client);
    }

    public function statutoryLeaves(): StatutoryLeaves
    {
        return new StatutoryLeaves($this->client);
    }
}
