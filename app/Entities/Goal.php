<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Goal
 *
 * @property int $id
 * @property string $value_ru
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $value_en
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal whereValueEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Goal whereValueRu($value)
 * @mixin \Eloquent
 */
class Goal extends Model
{
    protected $table = 'goals';
    protected $hidden = ['pivot', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_to_goals', 'goal_id', 'user_id');
    }

    public function images()
    {

    }
}
