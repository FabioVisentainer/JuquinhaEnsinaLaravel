<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkByStudent extends Model
{
    use HasFactory;

    protected $table = 'homework_by_student';
    public $timestamps = true;

    protected $fillable = [
        'entity_id',
        'student_user_id',
        'homework_id',
        'class_id',
        'completion_time',
        'number_of_clicks',
        'correct_answers',
        'error_count',
        'estimated_time_to_complete',
        'estimated_clicks_to_complete'
    ];

    // Relationship with Homework
    public function homework()
    {
        return $this->belongsTo(Homework::class, 'homework_id');
    }

    // Relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_user_id');
    }

    // Relationship with ClassModel
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}