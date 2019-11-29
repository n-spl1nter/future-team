<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\EmailMessage
 *
 * @property int $id
 * @property int $user_id_from
 * @property int $user_id_to
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\User $userFrom
 * @property-read \App\Entities\User $userTo
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage whereUserIdFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\EmailMessage whereUserIdTo($value)
 * @mixin \Eloquent
 */
class EmailMessage extends Model
{
    protected $table = 'email_messages';
    protected $fillable = ['user_id_to', 'message'];

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_id_from', 'id');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'user_id_to', 'id');
    }
}
