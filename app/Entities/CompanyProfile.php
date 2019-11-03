<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\CompanyProfile
 *
 * @property int $id
 * @property string $full_name
 * @property int $country_id
 * @property string|null $logo
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $organization_type_id
 * @property int $user_id
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereOrganizationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\CompanyProfile whereUserId($value)
 * @mixin \Eloquent
 */
class CompanyProfile extends Model
{
    protected $table = 'company_profiles';
    protected $fillable = [
        'full_name', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getOnCreateValidationRules(): array
    {
        return [

        ];
    }
}
