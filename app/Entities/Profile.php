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
 * @property \Illuminate\Support\Carbon $birth_date_at
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereBirthDateAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereLanguageExchangeAgreement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereMotivation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Profile whereUserId($value)
 * @mixin \Eloquent
 */
class Profile extends Model
{
    protected $table = 'profiles';
    protected $dates = ['birth_date_at'];
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'phone', 'birth_date_at', 'language_exchange_agreement',
        'city_id', 'activity_field_id', 'motivation',
    ];

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

    public static function getOnCreateValidationRules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:255',
            'middle_name' => 'nullable|string|min:2|max:255',
            'last_name' => 'nullable|string|min:2|max:255',
            'phone' => 'required|string|size:11|regex:/[0-9]{11}/',
            'photo' => 'required|image|dimensions:min_width=140,min_height=140',
            'birth_date_at' => 'required|date',
            'language_exchange_agreement' => 'nullable|integer|in:0,1',
            'city_id' => 'required|integer|exists:_cities,city_id',
            'activity_field_id' => 'required|integer|exists:activity_fields,id',
            'motivation' => 'required|string|max:500',
        ];
    }
}
