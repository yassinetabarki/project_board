<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Throwable;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        $project=ProjectFactory::create();
        $this->actingAs($project->owner)->post($project->path().'/tasks',['body'=>'test task']);
        $this->get($project->path())->assertSee('test task');
    }
    /**
     * @test
     */
    public function a_task_require_a_body()
    {
       $project=ProjectFactory::create();
        $attributes=factory('App\Task')->raw(['body'=> '']);

        $this->actingAs($project->owner)->post($project->path().'/tasks/',$attributes)
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function only_the_project_owner_can_update_their_tasks()
    {
        $this->signIn();
      $project=ProjectFactory::withTask(1)
          ->create();
        $this->patch($project->tasks[0]->path(),['body'=>'changed'])
        ->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body'=>'changed']);
    }
    /**
     * @test
     */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $project=ProjectFactory::withTask(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),['body'=>'changed']);

        $this->assertDatabaseHas('tasks',['body'=>'changed']);
    }
    /**
     * @test
     */
    public function a_task_can_be_completed()
    {
        $this->withoutExceptionHandling();
        $project=ProjectFactory::withTask(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
            'body'=>'changed',
            'completed'=>true
        ]);
        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
            'completed'=>true
            ]);
    }
    /**
     * @test
     */
    public function a_task_can_be_incomplete()
    {
        $this->withoutExceptionHandling();
        $project=ProjectFactory::withTask(1)
            ->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
                'body'=>'changed',
                'completed'=>true
            ]);
        $this->actingAs($project->owner)
            ->patch($project->tasks->first()->path(),[
                'body'=>'changed',
                'completed'=>false
            ]);

        $this->assertDatabaseHas('tasks',[
            'body'=>'changed',
            'completed'=>false
        ]);
    }
}
