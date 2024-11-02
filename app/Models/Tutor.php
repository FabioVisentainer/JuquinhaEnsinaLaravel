<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $table = 'tb_tutors'; // Specify the table associated with the model
    protected $primaryKey = 'tutor_id'; // Specify the primary key for the table

    protected $fillable = [
        'entity_id',
        'tutor_user_id',
        'address_id',
        'tutor_name',
        'tutor_birth_date',
        'tutor_cpf_number',
        'tutor_contact_number',
        'tutor_contact_mail',
        'tutor_registry_date',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'tutor_user_id', 'user_id'); // Ensure this is correct
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id'); // Define the relationship to Address
    }

    /*public function students() //Código funcional
    {
        return $this->belongsToMany(Student::class, 'student_by_tutor', 'tutor_user_id', 'student_user_id')
                    ->whereColumn('tb_students.user_id', 'student_by_tutor.student_user_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }*/


    public function students()
    {
        // Ensure this matches your pivot table correctly
        return $this->belongsToMany(Student::class, 'student_by_tutor', 'tutor_user_id', 'student_user_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }


    public function studentRelations()
    {
        return $this->hasMany(StudentByTutor::class, 'tutor_user_id', 'tutor_user_id'); // Use the StudentByTutor model without withTimestamps()
    }
}