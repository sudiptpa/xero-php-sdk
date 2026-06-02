<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Projects;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Projects\TimeEntry\TimeEntry;
use Sujip\Xero\Support\Json;
use Sujip\Xero\Xero;

final class TimeEntriesTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_delete_time_entries(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'TimeEntries' => [[
                'TimeEntryID' => 'time-1',
                'TaskID' => 'task-1',
                'UserID' => 'user-1',
                'DateUTC' => '2026-03-26T00:00:00Z',
                'Status' => 'INPROGRESS',
                'Duration' => 90,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'TimeEntry' => [
                'TimeEntryID' => 'time-1',
                'TaskID' => 'task-1',
                'UserID' => 'user-1',
                'Duration' => 90,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'TimeEntry' => [
                'TimeEntryID' => 'time-2',
                'TaskID' => 'task-1',
                'UserID' => 'user-1',
                'Duration' => 120,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'TimeEntry' => [
                'TimeEntryID' => 'time-2',
                'TaskID' => 'task-1',
                'UserID' => 'user-1',
                'Duration' => 150,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $entries = $client->projects()->timeEntries('project-1')
            ->user('user-1')
            ->task('task-1')
            ->states('inprogress')
            ->isChargeable()
            ->dateAfterUtc(new DateTimeImmutable('2026-03-01T00:00:00+00:00'))
            ->get();

        $entry = $client->projects()->timeEntries('project-1')->find('time-1');
        $created = $client->projects()->timeEntries('project-1')->create()
            ->task('task-1')
            ->user('user-1')
            ->date('2026-03-26T00:00:00Z')
            ->durationMinutes(120)
            ->save();
        $updated = $created->durationMinutes(150)->save();
        $updated->delete();

        self::assertSame('/projects.xro/2.0/Projects/project-1/Time', $transport->requests()[0]->path);
        self::assertSame('user-1', $transport->requests()[0]->query['userId']);
        self::assertSame('task-1', $transport->requests()[0]->query['taskId']);
        self::assertSame('INPROGRESS', $transport->requests()[0]->query['states']);
        self::assertSame('true', $transport->requests()[0]->query['isChargeable']);
        self::assertSame('2026-03-01T00:00:00+00:00', $transport->requests()[0]->query['dateAfterUtc']);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Time/time-1', $transport->requests()[1]->path);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Time', $transport->requests()[2]->path);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Time/time-2', $transport->requests()[3]->path);
        self::assertSame('DELETE', $transport->requests()[4]->method);
        $json2 = $transport->requests()[2]->json ?? [];
        self::assertSame('task-1', $json2['taskId'] ?? null);
        self::assertSame('user-1', $json2['userId'] ?? null);
        self::assertSame('2026-03-26T00:00:00Z', $json2['dateUtc'] ?? null);
        self::assertSame(120, $json2['duration'] ?? null);
        self::assertNotNull($entries->first());
        self::assertSame(150, $updated->getDuration());
        self::assertSame('time-1', $entry?->getTimeEntryID());
    }
}
