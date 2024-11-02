<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Specify the table associated with the model
    protected $table = 'tb_students';

    // Specify the primary key for the table
    protected $primaryKey = 'student_id';

    // Allow mass assignment for these fields
    protected $fillable = [
        'special_need_id',
        'student_name',
        'student_gender',
        'student_birth_date',
        'student_cpf_number',
        'student_registry_date',
        'entity_id',
        'student_user_id',
        'is_active',
    ];

    public $incrementing = true;

    protected $keyType = 'int';

    // Relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'student_user_id', 'user_id');
    }

    public function tutors()
    {
        return $this->belongsToMany(Tutor::class, 'student_by_tutor', 'student_user_id', 'tutor_user_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'student_by_class', 'student_user_id', 'class_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }



}