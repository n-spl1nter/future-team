<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\MailSubscribe
 *
 * @property int $id
 * @property string $email
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe inActive()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\MailSubscribe whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MailSubscribe extends Model
{
    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';

    protected $table = 'mailing_subscribes';
    protected $fillable = ['email'];

    public function scopeActive(Builder $builder)
    {
        return $builder->where('status', '=', self::STATUS_ACTIVE);
    }

    public function scopeInActive(Builder $builder)
    {
        return $builder->where('status', '=', self::STATUS_INACTIVE);
    }

    public function markActive(): self
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
        return $this;
    }

    public function markInActive(): self
    {
        $this->status = self::STATUS_INACTIVE;
        $this->save();
        return $this;
    }
}
