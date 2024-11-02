<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeworkByClass extends Model
{
    use HasFactory;

    protected $table = 'homework_by_class';
    public $timestamps = true;

    protected $fillable = [
        'entity_id',
        'homework_id',
        'class_id',
        'teacher_user_id',
        'description',
        'due_date',
        'release_date'
    ];

    // Relationship with Homework
    public function homework()
    {
        return $this->belongsTo(Homework::class, 'homework_id');
    }

    // Relationship with ClassModel
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    // Relationship with Teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user_id');
    }
}