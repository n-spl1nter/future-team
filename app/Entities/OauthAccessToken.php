<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\OauthAccessToken
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $client_id
 * @property string|null $name
 * @property string|null $scopes
 * @property int $revoked
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereRevoked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereScopes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OauthAccessToken whereUserId($value)
 * @mixin \Eloquent
 */
class OauthAccessToken extends Model
{
    protected $hidden = ['id', 'user_id', 'client_id', 'scopes', 'revoked'];
    protected $dates = ['expires_at'];
}
