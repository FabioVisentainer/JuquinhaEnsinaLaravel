<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    // Define the table name
    protected $table = 'tb_class_subjects';

    // Define the primary key
    protected $primaryKey = 'class_subject_id';

    // Fields that are mass assignable
    protected $fillable = [
        'entity_id',
        'class_subject_name',
        'is_active',
    ];

    // Automatically handle timestamps
    public $timestamps = true;

    // Define the default attributes for timestamps
    protected $attributes = [
        'is_active' => true,
    ];

    // Define the relationship with the entity
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'entity_id');
    }


    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'subject_by_class', 'class_subject_id', 'class_id')
                    ->withPivot('entity_id')
                    ->withTimestamps();
    }


}