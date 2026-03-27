<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Projects;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Projects\Task\Task;
use Sujip\Xero\Xero;

final class TasksTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_delete_tasks(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'Tasks' => [[
                'TaskID' => 'task-1',
                'Name' => 'Discovery',
                'ChargeType' => 'TIME',
                'Rate' => 150,
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Task' => [
                'TaskID' => 'task-1',
                'Name' => 'Discovery',
                'ChargeType' => 'TIME',
                'Rate' => 150,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Task' => [
                'TaskID' => 'task-2',
                'Name' => 'Build',
                'ChargeType' => 'TIME',
                'Rate' => 180,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'Task' => [
                'TaskID' => 'task-2',
                'Name' => 'Build and QA',
                'ChargeType' => 'TIME',
                'Rate' => 200,
            ],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204));

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $tasks = $client->projects()->tasks('project-1')->chargeType('time')->page(1)->perPage(10)->get();
        $task = $client->projects()->tasks('project-1')->find('task-1');
        $created = $client->projects()->tasks('project-1')->create()
            ->name('Build')
            ->chargeType('time')
            ->rate(180)
            ->save();
        $updated = $created->name('Build and QA')->rate(200)->save();
        $updated->delete();

        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks', $transport->requests()[0]->path);
        self::assertSame('TIME', $transport->requests()[0]->query['chargeType']);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks/task-1', $transport->requests()[1]->path);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks', $transport->requests()[2]->path);
        self::assertSame('Build', $transport->requests()[2]->json['Name']);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks/task-2', $transport->requests()[3]->path);
        self::assertSame('DELETE', $transport->requests()[4]->method);
        self::assertInstanceOf(Task::class, $tasks->first());
        self::assertSame('Build and QA', $updated->name);
        self::assertSame('task-1', $task?->id);
    }
}
