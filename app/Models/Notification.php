<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';
    protected $fillable = [
        'receiver_id',
        'Subject',
        'notification',
        'notification_link',
        'is_seen',
    ];
}
