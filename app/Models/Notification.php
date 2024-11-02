<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'tb_notifications';

    protected $fillable = [
        'entity_id',
        'from_user_id',
        'for_user_id',
        'notifications_message',
        'notification_title',
    ];
    
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function forUser()
    {
        return $this->belongsTo(User::class, 'for_user_id');
    }
}