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
 * @property-read \App\Entities\Country $country
 * @property-read \App\Entities\OrganizationType|null $organizationType
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile query()
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
 */
class CompanyProfile extends Model
{
    protected $table = 'company_profiles';
    protected $fillable = [ 'description', 'contact_person_name', 'cooperation_type', 'country_id' ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function organizationType()
    {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id', 'id');
    }

    public function getPublicProfile()
    {
        $data = $this->toArray();
        return $data;
    }

    public static function getOnCreateValidationRules(): array
    {
        return [
            'full_name' => 'required|string|unique:company_profiles,full_name',
            'country_id' => 'required|integer',
            'description' => 'nullable|string|max:1500',
            'goals' => 'required|array|min:1|max:5',
            'goals.*' => 'required|integer|exists:goals,id',
            'organization_type_id' => 'nullable|exists:organization_types,id',
            'organization_type' => 'nullable|required_without:organization_type_id|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,bmp,png|dimensions:min_width=200,min_height=200|max:10240',
            'terms' => 'required|accepted',
            'contact_person_name' => 'required|string|max:150',
            'cooperation_type' => 'required|string|min:10|max:1500',
        ];
    }

    public static function getOnUpdateValidationRules(): array
    {
        return [
            'country_id' => 'required|integer',
            'description' => 'nullable|string|max:1500',
            'goals' => 'required|array|min:1|max:5',
            'goals.*' => 'required|integer|exists:goals,id',
            'organization_type_id' => 'nullable|exists:organization_types,id',
            'organization_type' => 'nullable|required_without:organization_type_id|string|max:100',
//            'photo' => 'nullable|image|mimes:jpeg,bmp,png|dimensions:min_width=200,min_height=200|max:10240',
            'contact_person_name' => 'required|string|max:150',
            'cooperation_type' => 'required|string|min:10|max:1500',
        ];
    }

    public function toArray()
    {
        $this->load(['organizationType']);
        return parent::toArray();
    }

    public static function getDistinctCountries()
    {
        $query = "SELECT DISTINCT company_profiles.country_id, _countries.title_ru, _countries.title_en FROM `company_profiles`
INNER JOIN _countries ON _countries.country_id = company_profiles.country_id";
        return \DB::select(\DB::raw($query));
    }
}
