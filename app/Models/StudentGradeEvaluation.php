<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGradeEvaluation extends Model
{
    use HasFactory;

    protected $table = 'tb_student_grade_evaluation';
    
    protected $primaryKey = 'evaluation_id'; 

    protected $fillable = [
        'entity_id',
        'student_user_id',
        'class_id',
        'evaluation_number',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_user_id', 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(StudentGrade::class, 'evaluation_id', 'evaluation_id');
    }
}