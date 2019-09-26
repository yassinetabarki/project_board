<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordActivity;
    protected $guarded=[];


    public function path()
    {
        return "/projects/{$this->id}";
    }


    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
        
    }
}