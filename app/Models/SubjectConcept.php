<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectConcept extends Model
{
    use HasFactory;

    protected $table = 'tb_subjects_concepts';

    protected $fillable = [
        'concept_name',
        'concept_description',
        'concept_abbreviation',
        'concept_weight',
    ];
}