<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chronogram extends Model
{
    use HasFactory;

    protected $table = 'tb_chronogram';
    protected $primaryKey = 'chronogram_id';
    protected $fillable = [
        'entity_id',
        'chronogram_name',
        'is_active',
    ];
    public $timestamps = true;

    // Relationship to Teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_user_id', 'user_id');
    }

    // Relationship to Teacher
    public function teachername()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user_id', 'teacher_user_id');
    }

    // Relationship to Classes
    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'chronogram_by_class', 'chronogram_id', 'class_id');
    }

    // Relationship to Homeworks
    public function homeworks()
    {
        return $this->belongsToMany(Homework::class, 'homework_by_chronogram', 'chronogram_id', 'homework_id')
                    ->withPivot('release_date', 'due_date') // Include pivot fields
                    ->withTimestamps(); // Include timestamps
    }

    // Relationship to Entity
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'entity_id');
    }
}