<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordActivity;
    protected $guarded=[];
    protected $touches=['project'];

    protected $casts=[
        'completed'=> 'boolean'
    ];
    protected static $recordableEvents=['created','deleted'];

    public function complete()
    {
        $this->update(['completed'=> true]);
        $this->recordActivity('completed_task'); //or method 2
    }

    public function incomplete()
    {
        $this->update(['completed'=> false]);
//        $this->project->recordActivity('uncompleted_task');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "projects/{$this->project->id}/tasks/{$this->id}";
    }



}
