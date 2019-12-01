<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Activity
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property array|null $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Activity whereUserId($value)
 * @mixin \Eloquent
 */
class Activity extends Model
{
    const REGISTRATION = 'REGISTRATION';
    const ACTION_JOIN = 'ACTION_JOIN';
    const ACTION_ADD = 'ACTION_ADD';
    const EVENT_ADD = 'EVENT_ADD';
    const SEND_MESSAGE = 'SEND_MESSAGE';

    protected $table = 'user_activities';
    protected $fillable = ['type', 'info'];
    protected $casts = ['info' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
