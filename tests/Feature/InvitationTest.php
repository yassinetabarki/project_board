<?php

namespace Tests\Feature;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/
    public function only_the_project_owner_may_invite_users()
    {
        $project=ProjectFactory::create();
        $user=factory(User::class)->create();

        $this->actingAs($user)
            ->post($project->path().'/invitations')
            ->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)
            ->post($project->path().'/invitations')
            ->assertStatus(403);

    }

    /** @test*/
    public function the_invited_email_must_be_a_valid_email_michou_account()
    {
        $project=ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path().'/invitations',[
                'email'=> 'someemail@some.com'
             ])
            ->assertSessionHasErrors([
                'email' => 'The user email must be a valid michou account'
            ],null,'invitations');
    }
    
    /** @test*/
    public function a_project_can_invite_user()
    {
        $project=ProjectFactory::create();
        $userToInvite=factory(User::class)->create();

        $this->actingAs($project->owner)->post($project->path().'/invitations',[
            'email'=> $userToInvite->email
        ])->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }
    /** @test*/
    public function invited_user_may_change_details()
    {
        $project=ProjectFactory::create();

        $project->invite($newUser= factory(User::class)->create());
        $this->signIn($newUser);

        $this->get($project->path())->assertStatus(200);

        $this->post(action('ProjectTasksController@store',$project),$task=['body'=> 'foo task']);

        $this->assertDatabaseHas('tasks',$task);
    }
}
