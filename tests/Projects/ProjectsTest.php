<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Projects;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Xero;

final class ProjectsTest extends TestCase
{
    public function test_it_can_query_find_create_update_and_patch_projects(): void
    {
        $transport = new FakeTransport();
        $transport->push(new Response(200, body: json_encode([
            'items' => [[
                'projectId' => 'project-1',
                'name' => 'Website rebuild',
                'status' => 'INPROGRESS',
                'contactId' => 'contact-1',
                'deadlineUtc' => '2026-04-30T00:00:00Z',
            ]],
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(200, body: json_encode([
            'projectId' => 'project-1',
            'name' => 'Website rebuild',
            'status' => 'INPROGRESS',
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(201, body: json_encode([
            'projectId' => 'project-2',
            'name' => 'Mobile app',
            'status' => 'INPROGRESS',
        ], JSON_THROW_ON_ERROR)));
        $transport->push(new Response(204, body: '')); // update -> 204 No Content
        $transport->push(new Response(204, body: '')); // patch close -> 204 No Content
        $transport->push(new Response(204, body: '')); // patch reopen -> 204 No Content

        $client = Xero::withAccessToken('token', $transport)->tenant('tenant-123');

        $projects = $client->projects()
            ->contact('contact-1')
            ->states('inprogress')
            ->page(2)
            ->perPage(25)
            ->get();

        $project = $client->projects()->find('project-1');

        $created = $client->projects()->create()
            ->title('Mobile app')
            ->contact('contact-1')
            ->deadline(new DateTimeImmutable('2026-04-30T00:00:00+00:00'))
            ->save();

        $updated = $created->name('Mobile app v2')->save();
        $closed = $updated->close();
        $reopened = $closed->reopen();

        self::assertSame('/projects.xro/2.0/Projects', $transport->requests()[0]->path);
        self::assertSame('contact-1', $transport->requests()[0]->query['contactID']);
        self::assertSame('INPROGRESS', $transport->requests()[0]->query['states']);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(25, $transport->requests()[0]->query['pageSize']);
        $firstProject = $projects->first();
        self::assertNotNull($firstProject);
        self::assertSame('/projects.xro/2.0/Projects/project-1', $transport->requests()[1]->path);
        self::assertSame('/projects.xro/2.0/Projects', $transport->requests()[2]->path);
        $json2 = $transport->requests()[2]->json ?? [];
        self::assertSame('Mobile app', $json2['name'] ?? null);
        self::assertSame('/projects.xro/2.0/Projects/project-2', $transport->requests()[3]->path);
        self::assertSame('PATCH', $transport->requests()[4]->method);
        self::assertSame('/projects.xro/2.0/Projects/project-2', $transport->requests()[4]->path);
        $json4 = $transport->requests()[4]->json ?? [];
        self::assertSame('CLOSED', $json4['status'] ?? null);
        self::assertSame('PATCH', $transport->requests()[5]->method);
        $json5 = $transport->requests()[5]->json ?? [];
        self::assertSame('INPROGRESS', $json5['status'] ?? null);
        self::assertSame('Mobile app v2', $updated->getName());
        self::assertSame('CLOSED', $closed->getStatus());
        self::assertSame('INPROGRESS', $reopened->getStatus());
        self::assertSame('project-1', $project?->getProjectId());
        self::assertSame('contact-1', $firstProject->getContactId());
        self::assertSame('2026-04-30T00:00:00Z', $firstProject->getDeadlineUtc());
    }
}
