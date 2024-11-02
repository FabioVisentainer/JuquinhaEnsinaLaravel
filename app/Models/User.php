<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Change this line
use Illuminate\Notifications\Notifiable; // Include Notifiable trait for notifications
use Illuminate\Support\Facades\Hash; // Include Hash facade for password hashing

class User extends Authenticatable // Change this line
{
    use HasFactory, Notifiable; // Add Notifiable to enable notifications if needed

    protected $table = 'tb_users'; // Specify your table name
    protected $primaryKey = 'user_id'; // Specify your primary key if it's different
    
    // Define fillable fields if you want to use mass assignment
    protected $fillable = [
        'entity_id', // Added as it's part of your schema
        'username',
        'first_name',
        'last_name',
        'password_hash',
        'user_role',
        'is_active',
    ];

    // Optionally, you can define hidden fields like passwords
    protected $hidden = [
        'password_hash', // Keep this hidden in the JSON output
    ];

    // You can also define any relationships, accessors, or mutators if needed
    // For example, if you want to automatically hash the password when setting it:
    public function setPasswordAttribute($value)
    {
        $this->attributes['password_hash'] = Hash::make($value);
    }
}