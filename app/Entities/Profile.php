<?php

namespace App\Entities;

use Carbon\Carbon;
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
    protected $casts = ['motivation' => 'array'];
    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'phone', 'language_exchange_agreement',
        'city_id', 'activity_field_id', 'motivation',
    ];
    protected $hidden = ['id'];

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

    public function setBirthDate(string $date): self
    {
        $this->birth_date_at = Carbon::createFromFormat('Y-m-d', $date);
        return $this;
    }

    public static function getOnCreateValidationRules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:255',
            'middle_name' => 'nullable|string|min:2|max:255',
            'last_name' => 'nullable|string|min:2|max:255',
            'phone' => 'required|string|size:11|regex:/[0-9]{11}/',
            'birth_date_at' => 'required|date',
            'city_id' => 'required|integer|exists:_cities,city_id',
            'activity_field_id' => 'required|integer|exists:activity_fields,id',
            'goals' => 'required|array|min:1|max:5',
            'goals.*' => 'required|integer|exists:goals,id',
            'known_languages' => 'nullable|array|min:1',
            'known_languages.*' => 'integer|exists:languages,id',
            'languages_wltl' => 'nullable|array|min:1',
            'languages_wltl.*' => 'integer|exists:languages,id',
            'language_exchange_agreement' => 'nullable|integer|in:0,1',
            'motivation' => 'required|array|min:1',
            'photo' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=500,min_height=500',
            'about' => 'nullable|string|max:400',
            'terms' => 'required|accepted',
            'organization_id' => 'nullable|integer|exists:users,id',
            'organization_name' => 'nullable|string|max:100',
        ];
    }

    public static function getOnUpdateValidationRules(): array
    {
        return [

        ];
    }
}
