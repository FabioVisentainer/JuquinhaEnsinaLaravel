<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    // Set the name of the table to be used
    protected $table = 'tb_videos';

    // Specify the columns that are mass assignable
    protected $fillable = [
        'entity_id',
        'teacher_user_id',
        'video_url',
        'video_approval',
        'video_name',
    ];

    // Enable timestamps for created_at and updated_at
    public $timestamps = true;

    // Define relationships if needed
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_user_id');
    }

}