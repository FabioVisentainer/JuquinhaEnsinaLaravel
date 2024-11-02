<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'tb_homeworks';
    protected $primaryKey = 'homework_id'; // Fixed typo here
    public $timestamps = true;

    // Fillable attributes
    protected $fillable = ['homework_name', 'homework_url', 'homework_time_to_complete', 'homework_clicks_to_complete'];

    // Relationship to Chronograms
    public function chronograms()
    {
        return $this->belongsToMany(Chronogram::class, 'homework_by_chronogram', 'homework_id', 'chronogram_id')
                    ->withPivot('release_date', 'due_date') // Include pivot fields
                    ->withTimestamps(); // Include timestamps
    }


    // Relationship with HomeworkByClass
    public function homeworkByClasses()
    {
        return $this->hasMany(HomeworkByClass::class, 'homework_id');
    }

    // Relationship with HomeworkByStudent
    public function homeworkByStudents()
    {
        return $this->hasMany(HomeworkByStudent::class, 'homework_id');
    }
}