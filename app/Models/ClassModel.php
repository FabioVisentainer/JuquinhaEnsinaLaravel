<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'tb_class';

    protected $primaryKey = 'class_id';

    public $timestamps = true; 

    protected $fillable = [
        'entity_id',
        'class_name',
        'class_year',
    ];

    protected $hidden = [];

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'entity_id');
    }

    public function chronograms()
    {
        return $this->belongsToMany(Chronogram::class, 'chronogram_by_class', 'class_id', 'chronogram_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }


    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_by_class', 'class_id', 'teacher_user_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }


    public function subjects()
    {
        return $this->belongsToMany(ClassSubject::class, 'subject_by_class', 'class_id', 'class_subject_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }


    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_by_class', 'class_id',  'student_user_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }



}