<?php

declare(strict_types=1);

namespace Sujip\Xero\Tests\Projects;

use PHPUnit\Framework\TestCase;
use Sujip\Xero\Http\FakeTransport;
use Sujip\Xero\Http\Response;
use Sujip\Xero\Projects\ProjectUser\ProjectUser;
use Sujip\Xero\Xero;

final class ProjectUsersTest extends TestCase
{
    public function test_it_can_list_project_users(): void
    {
        $transport = (new FakeTransport())->push(new Response(200, body: json_encode([
            'Users' => [[
                'UserID' => 'user-1',
                'Name' => 'Natasha Romanoff',
                'Email' => 'natasha@example.test',
            ]],
        ], JSON_THROW_ON_ERROR)));

        $users = Xero::withAccessToken('token', $transport)
            ->tenant('tenant-123')
            ->projects()
            ->users()
            ->page(2)
            ->perPage(100)
            ->get();

        self::assertSame('/projects.xro/2.0/ProjectsUsers', $transport->requests()[0]->path);
        self::assertSame(2, $transport->requests()[0]->query['page']);
        self::assertSame(100, $transport->requests()[0]->query['pageSize']);
        self::assertInstanceOf(ProjectUser::class, $users->first());
    }
}
