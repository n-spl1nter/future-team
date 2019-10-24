<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\ActivityField
 *
 * @property int $id
 * @property string $value_ru
 * @property string|null $description_ru
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $value_en
 * @property string|null $description_en
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField whereDescriptionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField whereDescriptionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField whereValueEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\ActivityField whereValueRu($value)
 * @mixin \Eloquent
 */
class ActivityField extends Model
{
    protected $table = 'activity_fields';
    protected $fillable = ['value_ru', 'description_ru', 'value_en', 'description_en'];
    protected $hidden = ['created_at', 'updated_at'];
}
