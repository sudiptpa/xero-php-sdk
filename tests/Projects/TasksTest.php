<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Projects;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class TasksTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_delete_tasks(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'items' => [[
                'taskId' => 'task-1',
                'name' => 'Discovery',
                'chargeType' => 'TIME',
                'rate' => ['currency' => 'AUD', 'value' => 150],
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'taskId' => 'task-1',
            'name' => 'Discovery',
            'chargeType' => 'TIME',
            'rate' => ['currency' => 'AUD', 'value' => 150],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(201, body: json_encode([
            'taskId' => 'task-2',
            'name' => 'Build',
            'chargeType' => 'TIME',
            'rate' => ['currency' => 'AUD', 'value' => 180],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204)); // update -> 204 No Content
        $transport->push(new Response(204)); // delete -> 204 No Content

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $tasks = $client->projects()->tasks('project-1')->chargeType('time')->page(1)->perPage(10)->get();
        $task = $client->projects()->tasks('project-1')->find('task-1');
        $created = $client->projects()->tasks('project-1')->create()
            ->name('Build')
            ->chargeType('time')
            ->rate(180, 'AUD')
            ->save();
        $updated = $created->name('Build and QA')->rate(200, 'AUD')->save();
        $updated->delete();

        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks', $transport->requests()[0]->path);
        self::assertSame('TIME', $transport->requests()[0]->query['chargeType']);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks/task-1', $transport->requests()[1]->path);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks', $transport->requests()[2]->path);
        $json2 = $transport->requests()[2]->json ?? [];
        self::assertSame('Build', $json2['name'] ?? null);
        self::assertSame(['currency' => 'AUD', 'value' => 180], $json2['rate'] ?? null);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks/task-2', $transport->requests()[3]->path);
        $json3 = $transport->requests()[3]->json ?? [];
        self::assertSame(['currency' => 'AUD', 'value' => 200], $json3['rate'] ?? null);
        self::assertSame('DELETE', $transport->requests()[4]->method);
        self::assertSame('/projects.xro/2.0/Projects/project-1/Tasks/task-2', $transport->requests()[4]->path);
        self::assertNotNull($tasks->first());
        self::assertSame('task-2', $updated->getTaskId());
        self::assertSame('Build and QA', $updated->getName());
        self::assertSame(200, $updated->getRate()?->getValue());
        self::assertSame('task-1', $task?->getTaskId());
        self::assertSame(150, $task->getRate()?->getValue());
    }
}
