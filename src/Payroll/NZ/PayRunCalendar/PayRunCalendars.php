<?php

declare(strict_types=1);

namespace Sujip\Xero\Payroll\NZ\PayRunCalendar;

use Sujip\Xero\Client;
use Sujip\Xero\Support\Concerns\HasPagination;
use Sujip\Xero\Support\Contracts\DefinesScopes;
use Sujip\Xero\Support\Contracts\PaginatesResults;
use Sujip\Xero\Support\PaginatedCollection;
use Sujip\Xero\Support\ResourceCollection;
use Sujip\Xero\Support\ScopeRequirements;
use Sujip\Xero\Support\Json;

final class PayRunCalendars implements PaginatesResults, DefinesScopes
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
     * @return ResourceCollection<PayRunCalendar>
     */
    public function get(): ResourceCollection
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/PayRunCalendars')
            ->withQuery($this->paginationQuery())
            ->send();

        $payload = $response->json();
        $items = array_map(
            fn (array $calendar): PayRunCalendar => $this->mapPayRunCalendar($calendar),
            Json::extractList($payload, 'payRunCalendars')
        );

        return new ResourceCollection($items);
    }

    /**
     * @return PaginatedCollection<PayRunCalendar>
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

        return new PaginatedCollection($builder->get(), $builder->currentPage(), $builder->currentPerPage(), ['path' => '/payroll.xro/2.0/PayRunCalendars']);
    }

    public function find(string $payRunCalendarId): ?PayRunCalendar
    {
        $response = $this->client
            ->get('/payroll.xro/2.0/PayRunCalendars/' . $payRunCalendarId)
            ->send();

        $payload = $response->json();
        $calendar = Json::extractFirst($payload, 'payRunCalendars') ?? Json::extractObject($payload, 'payRunCalendar') ?: null;

        return $calendar !== null ? $this->mapPayRunCalendar($calendar) : null;
    }

    /**
     * @param array<string, mixed> $calendar
     */
    public function mapPayRunCalendar(array $calendar): PayRunCalendar
    {
        return (new PayRunCalendar())->fill($calendar);
    }
}
