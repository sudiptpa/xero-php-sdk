<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU;

use Sujip\Xero\Payroll\Shared\PayrollRegion;

final readonly class PayrollAU extends PayrollRegion
{
    public function employees(): Employees
    {
        return new Employees($this->client);
    }

    public function leaveApplications(): LeaveApplication\LeaveApplications
    {
        return new LeaveApplication\LeaveApplications($this->client);
    }

    public function payItems(): PayItem\PayItems
    {
        return new PayItem\PayItems($this->client);
    }

    public function payRuns(): PayRun\PayRuns
    {
        return new PayRun\PayRuns($this->client);
    }

    public function timesheets(): Timesheet\Timesheets
    {
        return new Timesheet\Timesheets($this->client);
    }

    public function settings(): Settings\Settings
    {
        return new Settings\Settings($this->client);
    }
}
