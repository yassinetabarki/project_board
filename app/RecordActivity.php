<?php

namespace App;


trait RecordActivity
{
    /**
     * The project's old attributes
     *
     * @var array
    */
    public $oldAttributes=[];

    /**
     * boot the trait
     */
    public static function bootRecordActivity()
    {
        foreach (self::recordableEvents() as $event){

            static::$event(function ($model) use($event){

                $model->recordActivity($model->activityDescription($event));
            });
            if($event === 'updated'){
                static::updating(function ($model){
                    $model->oldAttributes=$model->getOriginal();
                });
            }
        }
    }

    /**
     * Get the description of  the activity
     * @param $description
     * @return string
     */
    public function activityDescription($description)
    {
            return"{$description}_".strtolower(class_basename($this));

    }
    /**
     *Fetch the model that should trigger the activity
     *
     * @return array
     */
    protected static function recordableEvents()
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        } else {
            return ['created', 'updated'];
        }
    }

    /**
     * Fetch the changes to the model
     *
     * @return array
     */
    public function activityChanges()
    {
        if($this->wasChanged()) {
            return [
                'before'=>array_except(array_diff($this->oldAttributes,$this->getAttributes()),'updated_at'),
                'after'=>array_except($this->getChanges(),'updated_at')
            ];
        }
    }
    /**
     * Get the activity feed for a project
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class,'subject')->latest();
    }
    /**
     * Record the activity for a project
     *
     * @param string $description
     */
    public function recordActivity($description)
    {
        $this->activity()->create([
            'user_id'=> ($this->project ?? $this)->owner->id,
            'project_id'=> class_basename($this) ==='Project'? $this->id : $this->project->id,
            'description'=> $description,
            'changes'=> $this->activityChanges()
        ]);
    }

}