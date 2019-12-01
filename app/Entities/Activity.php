<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    const REGISTRATION = 'REGISTRATION';
    const ACTION_JOIN = 'ACTION_JOIN';
    const ACTION_ADD = 'ACTION_ADD';
    const EVENT_ADD = 'EVENT_ADD';
    const SEND_MESSAGE = 'SEND_MESSAGE';

    protected $table = 'user_activities';
    protected $fillable = ['type', 'info'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
