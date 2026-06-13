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
            'pagination' => [
                'page' => 2,
                'pageSize' => 100,
                'pageCount' => 1,
                'itemCount' => 1,
            ],
            'items' => [[
                'userId' => 'user-1',
                'name' => 'Natasha Romanoff',
                'email' => 'natasha@example.test',
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
        $user = $users->first();
        self::assertInstanceOf(ProjectUser::class, $user);
        self::assertSame('user-1', $user->getUserId());
        self::assertSame('Natasha Romanoff', $user->getName());
        self::assertSame('natasha@example.test', $user->getEmail());
    }
}
