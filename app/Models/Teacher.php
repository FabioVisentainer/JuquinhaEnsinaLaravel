<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'tb_teachers'; // Specify the table associated with the model
    protected $primaryKey = 'teacher_id'; // Specify the primary key for the table

    protected $fillable = [
        'entity_id',
        'teacher_user_id',
        'address_id',
        'teacher_name',
        'teacher_birth_date',
        'teacher_cpf_number',
        'teacher_contact_number',
        'teacher_contact_mail',
        'teacher_registry_date',
        'coordinator',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_user_id', 'user_id'); // Ensure this is correct
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id'); // Define the relationship to Address
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'teacher_by_class', 'teacher_user_id', 'class_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }

}