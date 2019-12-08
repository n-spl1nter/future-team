<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Language
 *
 * @property int $id
 * @property string $value_ru
 * @property string|null $locale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language whereValueRu($value)
 * @mixin \Eloquent
 * @property string|null $value_en
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Language whereValueEn($value)
 */
class Language extends Model
{
    protected $table = 'languages';
    protected $fillable = ['value_ru', 'locale'];
    protected $hidden = ['created_at', 'updated_at', 'pivot'];
}
