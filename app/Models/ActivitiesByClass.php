<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ActivitiesByClass extends Pivot
{
    protected $table = 'activities_by_class';

    protected $fillable = ['entity_id', 'class_id', 'activity_id', 'teacher_user_id'];

    public $incrementing = false;
    protected $primaryKey = ['class_id', 'activity_id'];
}