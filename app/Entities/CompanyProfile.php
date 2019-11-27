<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\CompanyProfile
 *
 * @property int $id
 * @property string $full_name
 * @property int $country_id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $organization_type_id
 * @property int $user_id
 * @property string|null $organization_type
 * @property string $cooperation_type
 * @property string $contact_person_name
 * @property string $contact_person_email
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereContactPersonEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereContactPersonName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereCooperationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereOrganizationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereOrganizationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Entities\OrganizationType|null $organizationType
 * @property-read \App\Entities\City $city
 */
class CompanyProfile extends Model
{
    protected $table = 'company_profiles';
    protected $fillable = [ 'description', 'contact_person_name', 'contact_person_email',
        'cooperation_type', 'country_id',
    ];
    protected $hidden = [
        'contact_person_email'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id', 'id');
    }

    public function getPublicProfile()
    {
        $data = $this->toArray();
        unset($data['contact_person_email']);
        return $data;
    }

    public static function getOnCreateValidationRules(): array
    {
        return [
            'full_name' => 'required|string|unique:company_profiles,full_name',
            'country_id' => 'required|integer|exists:_countries,country_id',
            'description' => 'nullable|string|max:1500',
            'goals' => 'required|array|min:1|max:5',
            'goals.*' => 'required|integer|exists:goals,id',
            'organization_type_id' => 'nullable|exists:organization_types,id',
            'organization_type' => 'nullable|required_without:organization_type_id|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,bmp,png|dimensions:min_width=640,min_height=480',
            'terms' => 'required|accepted',
            'contact_person_name' => 'required|string|max:150',
            'contact_person_email' => 'required|email',
            'cooperation_type' => 'required|string|min:10|max:1500',
        ];
    }

    public static function getOnUpdateValidationRules(): array
    {
        return [
            'country_id' => 'required|integer|exists:_countries,country_id',
            'description' => 'nullable|string|max:1500',
            'goals' => 'required|array|min:1|max:5',
            'goals.*' => 'required|integer|exists:goals,id',
            'organization_type_id' => 'nullable|exists:organization_types,id',
            'organization_type' => 'nullable|required_without:organization_type_id|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,bmp,png|dimensions:min_width=640,min_height=480',
            'contact_person_name' => 'required|string|max:150',
            'contact_person_email' => 'required|email',
            'cooperation_type' => 'required|string|min:10|max:1500',
        ];
    }

    public function toArray()
    {
        $this->load('organizationType');
        return parent::toArray();
    }
}
