<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Projects;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Sujip\Xero\Client;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Projects\Project\Amount;
use Sujip\Xero\Projects\Project\Project;
use Sujip\Xero\Projects\ProjectUser\ProjectUser;
use Sujip\Xero\Projects\Task\Task;
use Sujip\Xero\Projects\TimeEntry\TimeEntry;
use Sujip\Xero\Xero;

final class ProjectsCoverageTest extends TestCase
{
    private function client(FakeTransport $transport): Client
    {
        return Xero::withAccessToken('token', $transport)->tenant('tenant-1');
    }

    public function test_projects_facade_delegates_scopes_builders_and_accessors(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"items":[]}')); // paginate -> get
        $transport->push(new Response(200, body: '{"project":{"projectId":"p-1"}}')); // update -> save (PUT)
        $transport->push(new Response(200, body: '{"project":{"projectId":"p-1"}}')); // patch -> save (PATCH)
        $transport->push(new Response(200, body: '{"items":[{"projectId":"p-1"}]}')); // find via many fallback

        $client = $this->client($transport);
        $projects = $client->projects();

        self::assertSame(['projects'], $projects->scopes()->broad);
        self::assertSame($client, $projects->client());

        $built = $projects
            ->ids('p-1', 'p-2')
            ->contact('contact-1')
            ->states('inprogress')
            ->page(1)
            ->perPage(5);

        $paginated = $built->paginate(2, 10);
        self::assertSame(2, $paginated->page);

        $projects->update('p-1')->title('Renamed')->save();
        self::assertSame('PUT', $transport->requests()[1]->method);

        $projects->patch('p-1')->close()->save();
        self::assertSame('PATCH', $transport->requests()[2]->method);

        $found = $projects->find('p-1');
        self::assertSame('p-1', $found?->getProjectId());
    }

    public function test_project_entity_helpers_hydration_and_navigation(): void
    {
        $hydrated = (new Project())->fill([
            'contactId' => 'contact-9',
        ]);
        self::assertSame('contact-9', $hydrated->getContactId());

        $project = (new Project())
            ->status('inprogress')
            ->deadline('2026-12-31T00:00:00Z');
        self::assertSame('INPROGRESS', $project->getStatus());
        self::assertSame('2026-12-31T00:00:00Z', $project->getDeadlineUtc());

        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"project":{"projectId":"p-1","name":"Build"}}')); // find
        $transport->push(new Response(200, body: '{"project":{"projectId":"p-1","name":"Build"}}')); // save (PUT)

        $found = $this->client($transport)->projects()->find('p-1');
        self::assertNotNull($found);

        $saved = $found->setContactId('contact-1')->setDeadlineUtc('2026-12-31T00:00:00Z')->save();
        self::assertSame('p-1', $saved->getProjectId());

        self::assertSame(['projects'], $found->tasks()->scopes()->broad);
        self::assertSame(['projects'], $found->timeEntries()->scopes()->broad);
    }

    public function test_project_full_hydration_with_amounts(): void
    {
        $amount = ['currency' => 'AUD', 'value' => 99.5];

        $project = (new Project())->fill([
            'projectId' => 'p-1',
            'contactId' => 'contact-1',
            'name' => 'Build',
            'currencyCode' => 'AUD',
            'minutesLogged' => 120,
            'totalTaskAmount' => $amount,
            'totalExpenseAmount' => $amount,
            'estimateAmount' => $amount,
            'minutesToBeInvoiced' => 60,
            'taskAmountToBeInvoiced' => $amount,
            'taskAmountInvoiced' => $amount,
            'expenseAmountToBeInvoiced' => $amount,
            'expenseAmountInvoiced' => $amount,
            'projectAmountInvoiced' => $amount,
            'deposit' => $amount,
            'depositApplied' => $amount,
            'creditNoteAmount' => $amount,
            'deadlineUtc' => '2026-12-31T00:00:00Z',
            'totalInvoiced' => $amount,
            'totalToBeInvoiced' => $amount,
            'estimate' => $amount,
            'status' => 'inprogress',
        ]);

        self::assertSame('p-1', $project->getProjectId());
        self::assertSame('contact-1', $project->getContactId());
        self::assertSame('Build', $project->getName());
        self::assertSame('AUD', $project->getCurrencyCode());
        self::assertSame(120, $project->getMinutesLogged());
        self::assertSame(60, $project->getMinutesToBeInvoiced());
        self::assertSame('2026-12-31T00:00:00Z', $project->getDeadlineUtc());
        self::assertSame('INPROGRESS', $project->getStatus());

        foreach ([
            $project->getTotalTaskAmount(),
            $project->getTotalExpenseAmount(),
            $project->getEstimateAmount(),
            $project->getTaskAmountToBeInvoiced(),
            $project->getTaskAmountInvoiced(),
            $project->getExpenseAmountToBeInvoiced(),
            $project->getExpenseAmountInvoiced(),
            $project->getProjectAmountInvoiced(),
            $project->getDeposit(),
            $project->getDepositApplied(),
            $project->getCreditNoteAmount(),
            $project->getTotalInvoiced(),
            $project->getTotalToBeInvoiced(),
            $project->getEstimate(),
        ] as $value) {
            self::assertInstanceOf(Amount::class, $value);
            self::assertSame('AUD', $value->getCurrency());
            self::assertSame(99.5, $value->getValue());
        }
    }

    public function test_project_entity_guards_require_bound_context(): void
    {
        $cases = [
            ['save', 'Cannot save a project without a bound client context.'],
            ['tasks', 'Cannot access project tasks without a bound client context and project id.'],
            ['timeEntries', 'Cannot access project time entries without a bound client context and project id.'],
            ['close', 'Cannot close a project without a bound client context and project id.'],
            ['reopen', 'Cannot reopen a project without a bound client context and project id.'],
        ];

        foreach ($cases as [$method, $message]) {
            try {
                (new Project())->{$method}();
                self::fail("Expected RuntimeException for {$method}().");
            } catch (RuntimeException $e) {
                self::assertSame($message, $e->getMessage());
            }
        }
    }

    public function test_project_payload_supports_all_builders_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $project = $this->client($transport)->projects()
            ->create()
            ->title('Build')
            ->contact('contact-1')
            ->estimateAmount(1500.0)
            ->deadline(new DateTimeImmutable('2026-12-31T00:00:00Z'))
            ->idempotencyKey('key-1')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('key-1', $request->headers['Idempotency-Key']);
        self::assertSame(1500.0, $request->json['estimateAmount'] ?? null);
        self::assertNull($project->getProjectId());
    }

    public function test_project_patch_idempotency_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{}'));

        $project = $this->client($transport)->projects()
            ->patch('p-1')
            ->close()
            ->idempotencyKey('key-2')
            ->save();

        self::assertSame('key-2', $transport->requests()[0]->headers['Idempotency-Key']);
        self::assertSame('p-1', $project->getProjectId());
        self::assertSame('CLOSED', $project->getStatus());
    }

    public function test_project_user_model_getters(): void
    {
        $user = (new ProjectUser())
            ->setUserId('user-1')
            ->setName('Jane')
            ->setEmail('jane@example.com');

        self::assertSame('user-1', $user->getUserId());
        self::assertSame('Jane', $user->getName());
        self::assertSame('jane@example.com', $user->getEmail());
    }

    public function test_project_users_scopes_and_pagination(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: '{"items":[{"userId":"user-1"}]}'));

        $users = $this->client($transport)->projects()->users();

        self::assertSame(['projects'], $users->scopes()->broad);
        $paginated = $users->paginate(2, 10);
        self::assertSame(2, $paginated->page);
        self::assertNotNull($paginated->items->first());
    }

    public function test_task_model_getters_setters_and_rate_hydration(): void
    {
        $task = (new Task())
            ->setChargeType('time')
            ->rate(120.0, 'AUD')
            ->setProjectId('p-1')
            ->setStatus('active')
            ->setEstimateMinutes(60);

        self::assertSame('TIME', $task->getChargeType());
        $rate = $task->getRate();
        self::assertInstanceOf(Amount::class, $rate);
        self::assertSame(120.0, $rate->getValue());
        self::assertSame('AUD', $rate->getCurrency());
        self::assertSame('p-1', $task->getProjectId());
        self::assertSame('ACTIVE', $task->getStatus());
        self::assertSame(60, $task->getEstimateMinutes());

        $hydrated = (new Task())->fill([
            'rate' => ['currency' => 'AUD', 'value' => 99],
            'totalAmount' => ['currency' => 'AUD', 'value' => 198],
            'totalMinutes' => 120,
            'minutesInvoiced' => 0,
            'minutesToBeInvoiced' => 120,
            'fixedMinutes' => 0,
            'nonChargeableMinutes' => 0,
            'amountToBeInvoiced' => ['currency' => 'AUD', 'value' => 198],
            'amountInvoiced' => ['currency' => 'AUD', 'value' => 0],
        ]);
        self::assertSame(99, $hydrated->getRate()?->getValue());
        self::assertSame(198, $hydrated->getTotalAmount()?->getValue());
        self::assertSame(120, $hydrated->getTotalMinutes());
        self::assertSame(0, $hydrated->getMinutesInvoiced());
        self::assertSame(120, $hydrated->getMinutesToBeInvoiced());
        self::assertSame(0, $hydrated->getFixedMinutes());
        self::assertSame(0, $hydrated->getNonChargeableMinutes());
        self::assertSame(198, $hydrated->getAmountToBeInvoiced()?->getValue());
        self::assertSame(0, $hydrated->getAmountInvoiced()?->getValue());
    }

    public function test_task_entity_guards_require_bound_context(): void
    {
        try {
            (new Task())->save();
            self::fail('Expected RuntimeException for save().');
        } catch (RuntimeException $e) {
            self::assertSame('Cannot save a task without a bound client context and project id.', $e->getMessage());
        }

        try {
            (new Task())->delete();
            self::fail('Expected RuntimeException for delete().');
        } catch (RuntimeException $e) {
            self::assertSame('Cannot delete a task without a bound client context, project id, and task id.', $e->getMessage());
        }
    }

    public function test_tasks_resource_builders_pagination_update_and_find_fallback(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"items":[]}')); // paginate -> get
        $transport->push(new Response(204)); // update -> save (PUT, 204 No Content)
        $transport->push(new Response(200, body: '{"taskId":"t-1"}')); // find (unwrapped Task)

        $tasks = $this->client($transport)->projects()->tasks('p-1');

        self::assertSame(['projects'], $tasks->scopes()->broad);
        $paginated = $tasks->ids('t-1')->paginate(2, 10);
        self::assertSame(2, $paginated->page);

        $updated = $tasks->update('t-1')->name('Renamed')->save();
        self::assertSame('PUT', $transport->requests()[1]->method);
        self::assertSame('t-1', $updated->getTaskId());
        self::assertSame('Renamed', $updated->getName());

        $found = $tasks->find('t-1');
        self::assertSame('t-1', $found?->getTaskId());
    }

    public function test_task_payload_supports_estimate_idempotency_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(204));

        $task = $this->client($transport)->projects()->tasks('p-1')
            ->create()
            ->name('Design')
            ->estimateMinutes(120)
            ->idempotencyKey('key-3')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('key-3', $request->headers['Idempotency-Key']);
        self::assertSame(120, $request->json['estimateMinutes'] ?? null);
        self::assertSame('p-1', $task->getProjectId());
    }

    public function test_task_model_save_sends_estimate_minutes(): void
    {
        $transport = (new FakeTransport())->push(new Response(204));

        $task = (new Task($this->client($transport)))
            ->setProjectId('p-1')
            ->setName('Design')
            ->setChargeType('TIME')
            ->setEstimateMinutes(90)
            ->save();

        $request = $transport->requests()[0];
        self::assertSame(90, $request->json['estimateMinutes'] ?? null);
        self::assertSame('p-1', $task->getProjectId());
    }

    public function test_task_payload_rate_without_currency(): void
    {
        $transport = (new FakeTransport())->push(new Response(204));

        $this->client($transport)->projects()->tasks('p-1')
            ->create()
            ->name('Design')
            ->rate(120)
            ->save();

        $request = $transport->requests()[0];
        self::assertSame(['value' => 120], $request->json['rate'] ?? null);
    }

    public function test_time_entry_model_getters_and_setters(): void
    {
        $entry = (new TimeEntry())
            ->setTaskId('t-1')
            ->setUserId('user-1')
            ->setDateUtc('2026-03-01T00:00:00Z')
            ->setStatus('active')
            ->setProjectId('p-1')
            ->setDateEnteredUtc('2026-03-02T00:00:00Z')
            ->setDescription('Worked');

        self::assertSame('t-1', $entry->getTaskId());
        self::assertSame('user-1', $entry->getUserId());
        self::assertSame('2026-03-01T00:00:00Z', $entry->getDateUtc());
        self::assertSame('ACTIVE', $entry->getStatus());
        self::assertSame('p-1', $entry->getProjectId());
        self::assertSame('2026-03-02T00:00:00Z', $entry->getDateEnteredUtc());
        self::assertSame('Worked', $entry->getDescription());
    }

    public function test_time_entry_entity_guards_and_save_with_date(): void
    {
        try {
            (new TimeEntry())->save();
            self::fail('Expected RuntimeException for save().');
        } catch (RuntimeException $e) {
            self::assertSame('Cannot save a time entry without a bound client context and project id.', $e->getMessage());
        }

        try {
            (new TimeEntry())->delete();
            self::fail('Expected RuntimeException for delete().');
        } catch (RuntimeException $e) {
            self::assertSame('Cannot delete a time entry without a bound client context, project id, and time entry id.', $e->getMessage());
        }

        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"timeEntryId":"te-1"}')); // find
        $transport->push(new Response(204)); // save (PUT, 204 No Content)

        $found = $this->client($transport)->projects()->timeEntries('p-1')->find('te-1');
        self::assertNotNull($found);

        $saved = $found
            ->setTaskId('t-1')
            ->setUserId('user-1')
            ->setDateUtc('2026-03-01T00:00:00Z')
            ->durationMinutes(30)
            ->setDescription('Worked')
            ->save();

        self::assertSame('te-1', $saved->getTimeEntryId());
        self::assertSame(30, $saved->getDuration());
    }

    public function test_time_entries_resource_builders_pagination_update_and_find_fallback(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: '{"items":[]}')); // paginate -> get
        $transport->push(new Response(204)); // update -> save (PUT, 204 No Content)
        $transport->push(new Response(200, body: '{"timeEntryId":"te-1"}')); // find (unwrapped TimeEntry)

        $entries = $this->client($transport)->projects()->timeEntries('p-1');

        self::assertSame(['projects'], $entries->scopes()->broad);
        $built = $entries
            ->invoice('inv-1')
            ->contact('contact-1')
            ->dateBeforeUtc(new DateTimeImmutable('2026-03-01T00:00:00Z'));

        $paginated = $built->paginate(2, 10);
        self::assertSame(2, $paginated->page);

        $entries->update('te-1')->durationMinutes(15)->save();
        self::assertSame('PUT', $transport->requests()[1]->method);

        $found = $entries->find('te-1');
        self::assertSame('te-1', $found?->getTimeEntryId());
    }

    public function test_time_entry_payload_supports_all_builders_and_empty_response(): void
    {
        $transport = (new FakeTransport())->push(new Response(204));

        $entry = $this->client($transport)->projects()->timeEntries('p-1')
            ->create()
            ->task('t-1')
            ->user('user-1')
            ->date(new DateTimeImmutable('2026-03-01T00:00:00Z'))
            ->durationMinutes(45)
            ->description('Worked')
            ->idempotencyKey('key-4')
            ->save();

        $request = $transport->requests()[0];
        self::assertSame('key-4', $request->headers['Idempotency-Key']);
        self::assertSame('Worked', $request->json['description'] ?? null);
        self::assertSame('p-1', $entry->getProjectId());
        self::assertSame(45, $entry->getDuration());
    }
}
