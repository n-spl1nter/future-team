<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Country
 *
 * @property int $country_id
 * @property string|null $title_ru
 * @property string|null $title_ua
 * @property string|null $title_be
 * @property string|null $title_en
 * @property string|null $title_es
 * @property string|null $title_pt
 * @property string|null $title_de
 * @property string|null $title_fr
 * @property string|null $title_it
 * @property string|null $title_pl
 * @property string|null $title_ja
 * @property string|null $title_lt
 * @property string|null $title_lv
 * @property string|null $title_cz
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\City[] $cities
 * @property-read int|null $cities_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleBe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleCz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleDe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleEs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleIt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleJa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleLt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleLv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitlePl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitlePt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Country whereTitleUa($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    protected $table = '_countries';

    public function cities()
    {
        return $this->hasMany(City::class, 'city_id', 'country_id');
    }

    public static function getMainLocales()
    {
        return self::select(['country_id', 'title_ru', 'title_en'])
            ->orderBy('country_id')
            ->get();
    }
}
