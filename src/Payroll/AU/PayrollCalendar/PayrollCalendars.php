<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\AU\PayrollCalendar;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

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

        $items = array_map(
            fn (array $calendar): PayrollCalendar => $this->mapPayrollCalendar($calendar),
            Json::extractList($payload, 'PayrollCalendars')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<PayrollCalendar>
     */
    public function paginate(?int $page = null, ?int $perPage = null): PaginatedCollection
    {
        $builder = $this;

        if ($page !== null) {
            $builder = $builder->page($page);
        }

        if ($perPage !== null) {
            $builder = $builder->perPage($perPage);
        }

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/1.0/PayrollCalendars']);
    }

    public function find(string $payrollCalendarId): ?PayrollCalendar
    {
        $payload = $this->client
            ->get('/payroll.xro/1.0/PayrollCalendars/' . $payrollCalendarId)
            ->send()
            ->json();

        $calendar = Json::extractFirst($payload, 'PayrollCalendars') ?? Json::extractObject($payload, 'PayrollCalendar') ?: null;

        return $calendar !== null ? $this->mapPayrollCalendar($calendar) : null;
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
        return (new PayrollCalendar())->fill($calendar);
    }
}
