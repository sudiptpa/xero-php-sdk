<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayrollCalendar;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedResult;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;

final class PayrollCalendars implements PaginatesResults, DefinesScopes
{
    use HasPagination;

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

    /**
     * @return ResourceCollection<PayrollCalendar>
     */
    public function get(): ResourceCollection
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/PayrollCalendars')
            ->withQuery($this->paginationQuery())
            ->send()
            ->json();

        $items = array_values(array_map(
            fn (array $calendar): PayrollCalendar => $this->mapPayrollCalendar($calendar),
            $payload['PayrollCalendars'] ?? []
        ));

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedResult<PayrollCalendar>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedResult
    {
        $builder = $this;

        if ($page !== null) {
            $builder = $builder->page($page);
        }

        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        return new PaginatedResult($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/1.0/PayrollCalendars']);
    }

    public function find(string $payrollCalendarId): ?PayrollCalendar
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/PayrollCalendars/' . $payrollCalendarId)
            ->send()
            ->json();

        $calendar = $payload['PayrollCalendars'][0] ?? $payload['PayrollCalendar'] ?? null;

        return is_array($calendar) ? $this->mapPayrollCalendar($calendar) : null;
    }

    public function create(): Payload
    {
        return new Payload($this->client);
    }

    public function update(string $payrollCalendarId): Payload
    {
        return new Payload($this->client, $payrollCalendarId);
    }

    /**
     * @param array<string, mixed> $calendar
     */
    public function mapPayrollCalendar(array $calendar): PayrollCalendar
    {
        return (new PayrollCalendar())
            ->setPayrollCalendarID($calendar['PayrollCalendarID'] ?? null)
            ->setName($calendar['Name'] ?? null)
            ->setCalendarType($calendar['CalendarType'] ?? null)
            ->setStartDate($calendar['StartDate'] ?? null)
            ->setPaymentDate($calendar['PaymentDate'] ?? null)
            ;
    }
}
