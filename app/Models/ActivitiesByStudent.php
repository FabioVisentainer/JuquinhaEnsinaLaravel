<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ActivitiesByStudent extends Pivot
{
    protected $table = 'activities_by_student';

    protected $fillable = ['entity_id', 'student_user_id', 'activity_id', 'times_completed'];

    public $incrementing = false;
    protected $primaryKey = ['student_user_id', 'activity_id'];
}