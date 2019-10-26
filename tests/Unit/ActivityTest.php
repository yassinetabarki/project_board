<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
   use RefreshDatabase;

    /** @test */
    public function it_has_a_user ()
    {
        $user=$this->signIn();
        $project=ProjectFactory::ownedBy($user)->create();
        $this->assertEquals($user->id, $project->activity->first()->user->id);
    }
}

