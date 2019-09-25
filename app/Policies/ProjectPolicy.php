<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;


    //project can only be updated by the user
    public function update(User $user ,Project $project)
    {
        return $user->is($project->owner);
    }
}
