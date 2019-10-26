<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function A_project_belong_to_user()
    {
        $project=factory('App\Project')->create();
        $this->assertInstanceOf('App\User',$project->owner);
    }

    /**
     * @test
     */
    public function can_add_tasks()
    {
        $project=factory('App\Project')->create();

        $project->addTask('Test task');

        $this->assertCount(1,$project->tasks);
    }

    /** @test*/
    public function it_can_invite_a_user()
    {
        $project=factory('App\Project')->create();

        $project->invite($user = factory(User::class)->create());

        $this->assertTrue($project->members->contains($user));
    }

}
