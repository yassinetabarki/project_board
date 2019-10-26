<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function has_project()
    {
        $user=factory('App\User')->create();

        $this->assertInstanceOf(Collection::class,$user->projects);
    }
    /** @test*/
    public function has_accessible_projects()
    {
        $yass=$this->signIn();

        ProjectFactory::ownedBy($yass)->create();

        $this->assertcount(1,$yass->accessibleProjects());

        $michou=factory(User::class)->create();
        $douha=factory(User::class)->create();

        $michouProject=ProjectFactory::ownedBy($michou)->create();
        $michouProject->invite($douha);
        $this->assertcount(1,$yass->accessibleProjects());

        $michouProject->invite($yass);
        $this->assertcount(2,$yass->accessibleProjects());

    }
}
