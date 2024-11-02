<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubjectSyllabus extends Model
{
    protected $table = 'tb_class_subjects_syllabus';
    protected $primaryKey = 'class_syllabus_id';

    protected $fillable = [
        'entity_id', 'class_subject_id', 'class_syllabus_name', 'class_syllabus_description', 'is_active'
    ];

    public function classSubject()
    {
        return $this->belongsTo(ClassSubject::class, 'class_subject_id');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'syllabus_by_class', 'class_syllabus_id', 'class_id');
    }
    

}

