<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Profile
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string $phone
 * @property string $photo
 * @property int $age
 * @property int $language_exchange_agreement
 * @property int $city_id
 * @property int $activity_field_id
 * @property string $motivation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \App\Entities\ActivityField $activityField
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereActivityFieldId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereLanguageExchangeAgreement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereMotivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereUserId($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    protected $table = 'profiles';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function activityField()
    {
        return $this->belongsTo(ActivityField::class, 'activity_field_id', 'id');
    }
}
