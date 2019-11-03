<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\OrganizationType
 *
 * @property int $id
 * @property string $value_ru
 * @property string $value_en
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType whereValueEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\OrganizationType whereValueRu($value)
 * @mixin \Eloquent
 */
class OrganizationType extends Model
{
    protected $table = 'organization_types';
    protected $fillable = ['value_ru', 'value_en'];
}
