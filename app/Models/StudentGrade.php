<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    use HasFactory;

    protected $table = 'tb_student_grades';

    protected $fillable = [
        'entity_id',
        'teacher_user_id',
        'class_syllabus_id',
        'concept_id',
        'evaluation_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user_id', 'user_id');
    }

    public function syllabus()
    {
        return $this->belongsTo(ClassSubjectSyllabus::class, 'class_syllabus_id', 'class_syllabus_id');
    }

    public function concept()
    {
        return $this->belongsTo(SubjectConcept::class, 'concept_id', 'concept_id');
    }

    public function evaluation()
    {
        return $this->belongsTo(StudentGradeEvaluation::class, 'evaluation_id', 'evaluation_id');
    }
}