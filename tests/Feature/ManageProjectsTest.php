<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    /**
     * @test
     */
    public function guests_cannot_manage_project()
    {
        $project=ProjectFactory::create();

        $this->get('/projects')->assertRedirect('login');
        $this->post('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get($project->path().'/edit')->assertRedirect('login');
        $this->post('/projects/create',$project->toArray())->assertRedirect('login');
    }
    /**
     * @test
     */
    public function a_user_can_update_note()
    {
        $this->withoutExceptionHandling();

        $project=factory('App\Project')->create(['notes'=>'this note']);
        $this->actingAs($project->owner)->patch($project->path(),['notes'=>'changed']);
        $this->assertDatabaseHas('projects',['notes'=>'changed']);
    }
    /**
     * @test
     */
    public function a_user_can_create_project()
    {
         $this->signIn();
        $attributs=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->sentence,
            'notes' =>  'general note'
        ];
        $response=$this->post('/projects/create',$attributs);

        $project=Project::where($attributs)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects',$attributs);

        $this->get($project->path())
            ->assertSee($attributs['title'])
            ->assertSee($attributs['description'])
            ->assertSee($attributs['notes']);
    }

    /**
     * @test
     */
    public function a_user_can_update_project()
    {
        $project=ProjectFactory::create();
        $this->actingAs($project->owner)
            ->patch($project->path(),$attributs=['title'=>'changed','description'=>'changed','notes'=>'changed'])
            ->assertRedirect($project->path());
        $this->get($project->path().'/edit')->assertStatus(200);
        $this->assertDatabaseHas('projects',$attributs);
    }
    /**
     * @test
     */
    public function only_the_owner_of_a_project_my_add_tasks()
    {
        $this->signIn();

        $project=ProjectFactory::create();
        $this->post($project->path().'/tasks',$attributs=['body'=>'Test task'])
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks',$attributs);
    }
    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_projects_of_others()
    {
        $this->signIn();
        $project=ProjectFactory::create();
        $this->get($project->path())->assertStatus(403);
    }
    /**
     * @test
     */
    public function an_authenticated_user_cannot_update_projects_of_others()
    {
        $this->signIn();
        $project=ProjectFactory::create();
        $this->patch($project->path(),[])->assertStatus(403);
    }
    /**
     * @test
     */
    public function a_user_can_see_their_projects()
    {
        $project=ProjectFactory::create();
        $this->actingAs($project->owner)->get($project->path())
            ->assertSee($project->title)
            ->assertSee(str_limit($project->description));
    }
/**
 * @test
 */
    public function a_project_require_a_title()
    {
        $this->signIn();
        $attributes=factory('App\Project')->raw(['title'=> '']);
        $this->post('/projects/create',$attributes)->assertSessionHasErrors('title');
    }
    /**
     * @test
     */
    public function a_project_require_a_description()
    {
        $this->signIn();
        $attributes=factory('App\Project')->raw(['description'=> '']);
        $this->post('/projects/create',$attributes)->assertSessionHasErrors('description');
    }

}
