<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentByTutor extends Model
{
    protected $table = 'student_by_tutor'; // Specify the table name if it doesn't follow the default pluralization
    
    protected $fillable = ['entity_id', 'tutor_user_id', 'student_user_id']; // Specify the fillable attributes

    public $timestamps = true; // Enable timestamps if needed

    // Define the relationship with the Student model
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_user_id', 'student_user_id');
    }

    // Define the relationship with the Tutor model
    public function tutor()
    {
        return $this->belongsTo(Tutor::class, 'tutor_user_id', 'tutor_user_id');
    }
}