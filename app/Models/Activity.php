<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'tb_activities';

    // Define the primary key
    protected $primaryKey = 'activity_id';

    // Indicate that the primary key is an incrementing integer
    public $incrementing = true;
    protected $keyType = 'int';

    // Define fillable attributes to allow mass assignment
    protected $fillable = ['activity_name', 'activity_url'];

    // Relationship with students through activities_by_student // Não utilziar probelma entre user_id e student_user_id
    public function students()
    {
        return $this->belongsToMany(Student::class, 'activities_by_student', 'activity_id', 'student_user_id')
                    ->using(ActivitiesByStudent::class)
                    ->withPivot('entity_id', 'times_completed')
                    ->withTimestamps();
    }
    
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'activities_by_class', 'activity_id', 'class_id')
                    ->using(ActivitiesByClass::class)
                    ->withPivot('entity_id', 'teacher_user_id')
                    ->withTimestamps();
    }
}