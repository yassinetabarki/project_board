<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function (Faker $faker) {
    return [

        'body'=> $faker->paragraph,
        'project_id'=> factory(\App\Project::class)->create(),
        'completed'=>false
    ];
});
