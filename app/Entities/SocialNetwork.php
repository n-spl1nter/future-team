<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\SocialNetwork
 *
 * @property int $id
 * @property string $service
 * @property string $identity
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork whereIdentity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SocialNetwork whereUserId($value)
 * @mixin \Eloquent
 */
class SocialNetwork extends Model
{
    protected $table = 'social_networks';
    protected $fillable = ['service', 'identity', 'token'];
}
