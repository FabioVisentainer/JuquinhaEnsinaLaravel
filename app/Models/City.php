<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'tb_city'; // Specify the correct table name

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'state_id'); // Ensure the keys match your database structure
    }
}