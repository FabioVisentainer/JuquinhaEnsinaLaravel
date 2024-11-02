<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'tb_addresses'; // Specify the table name

    // Define the primary key
    protected $primaryKey = 'address_id'; // Specify the primary key column

    // If address_id is not an auto-incrementing integer
    public $incrementing = true; // Set to false if it's not auto-incrementing

    // Set the key type to string if it's not an integer
    protected $keyType = 'int'; // Adjust this to 'string' if the key type is a strin

    // Define the fillable attributes
    protected $fillable = [
        'cep_code',
        'adress_number',
        'adress_street_name',
        'city_id',
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id'); // Define the relationship with City
    }
}