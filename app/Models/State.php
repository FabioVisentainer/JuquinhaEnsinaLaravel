<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'tb_state'; // Define the table name if it doesn't follow conventions

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id'); // Ensure the keys match your database structure
    }

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'state_id'); // Define the inverse relationship
    }


    
}