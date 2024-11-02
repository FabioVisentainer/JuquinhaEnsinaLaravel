<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'tb_country'; // Define the table name if it doesn't follow conventions

    public function states()
    {
        return $this->hasMany(State::class, 'country_id', 'country_id'); // Define the inverse relationship
    }
}