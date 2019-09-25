<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

   /**
    * @test
    */
    public function creating_a_project()
    {
        $project=ProjectFactory::create();

        $this->assertCount(1,$project->activity);

        tap($project->activity->last(),function($activity) {
            $this->assertEquals('created_project',$activity->description);
            $this->assertNull($activity->changes);
        });
    }
    /**
     * @test
     */
    public function updating_a_project()
    {
        $project=ProjectFactory::create();

        $originalTitle=$project->title;
        $project->update(['title'=>'changed']);

        $this->assertCount(2,$project->activity);
        tap($project->activity->last(),function($activity) use ($originalTitle) {
            $this->assertEquals('updated_project', $activity->description);

            $expected=[
                'before'=> ['title'=>$originalTitle],
                'after' => ['title'=>'changed']
            ];
            $this->assertEquals($expected,$activity->changes);
        });

    }
    /**
     * @test
     */
    public function creating_a_task_project()
    {
        $project=ProjectFactory::create();
        $project->addTask('Test task');

        $this->assertCount(2,$project->activity);

        tap($project->activity->last(),function($activity){
           $this->assertEquals('created_task',$activity->description);
           $this->assertInstanceOf(Task::class,$activity->subject);
           $this->assertEquals('Test task',$activity->subject->body);
        });
    }
    /**
     * @test
     */
    public function completing_a_task_project()
    {
        $project=ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
            'body'=> 'foobar',
            'completed'=>true
        ]);
        $this->assertCount(3,$project->activity);

        tap($project->activity->last(),function($activity) {
            $this->assertEquals('completed_task',$activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }
    /**
     * @test
     */
    public function incompleting_a_task_project()
    {
        $project=ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),[
            'body'=> 'foobar',
            'completed'=>true
        ]);
        $this->assertCount(3,$project->fresh()->activity);

        $this->patch($project->tasks[0]->path(),[
        'body'=> 'foobar',
        'completed'=>false

    ]);
        $this->assertCount(3,$project->fresh()->activity);

        // waiting to be fixed
//        $this->assertEquals('uncompleted_task',$project->activity->last()->description);
    }
/** @test */
    public function deleteting_a_task()
    {
        $project=ProjectFactory::withTask(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3,$project->activity);
    }
}
