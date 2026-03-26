<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ;

use Sujip\Xero\Payroll\NZ\Employee\Employees;
use Sujip\Xero\Payroll\NZ\LeaveType\LeaveTypes;
use Sujip\Xero\Payroll\NZ\PayRun\PayRuns;
use Sujip\Xero\Payroll\NZ\PayRunCalendar\PayRunCalendars;
use Sujip\Xero\Payroll\NZ\Settings\Settings;
use Sujip\Xero\Payroll\NZ\Timesheet\Timesheets;
use Sujip\Xero\Payroll\Shared\PayrollRegion;

final readonly class PayrollNZ extends PayrollRegion
{
    public function employees(): Employees
    {
        return new Employees($this->client);
    }

    public function leaveTypes(): LeaveTypes
    {
        return new LeaveTypes($this->client);
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
}
