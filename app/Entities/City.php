<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\City
 *
 * @property int $city_id
 * @property int $country_id
 * @property int $important
 * @property int|null $region_id
 * @property string|null $title_ru
 * @property string|null $area_ru
 * @property string|null $region_ru
 * @property string|null $title_ua
 * @property string|null $area_ua
 * @property string|null $region_ua
 * @property string|null $title_be
 * @property string|null $area_be
 * @property string|null $region_be
 * @property string|null $title_en
 * @property string|null $area_en
 * @property string|null $region_en
 * @property string|null $title_es
 * @property string|null $area_es
 * @property string|null $region_es
 * @property string|null $title_pt
 * @property string|null $area_pt
 * @property string|null $region_pt
 * @property string|null $title_de
 * @property string|null $area_de
 * @property string|null $region_de
 * @property string|null $title_fr
 * @property string|null $area_fr
 * @property string|null $region_fr
 * @property string|null $title_it
 * @property string|null $area_it
 * @property string|null $region_it
 * @property string|null $title_pl
 * @property string|null $area_pl
 * @property string|null $region_pl
 * @property string|null $title_ja
 * @property string|null $area_ja
 * @property string|null $region_ja
 * @property string|null $title_lt
 * @property string|null $area_lt
 * @property string|null $region_lt
 * @property string|null $title_lv
 * @property string|null $area_lv
 * @property string|null $region_lv
 * @property string|null $title_cz
 * @property string|null $area_cz
 * @property string|null $region_cz
 * @property-read \App\Entities\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaBe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaCz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaDe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaEs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaIt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaJa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaLt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaLv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaPl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaPt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereAreaUa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereImportant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionBe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionCz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionDe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionEs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionIt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionJa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionLt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionLv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionPl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionPt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereRegionUa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleBe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleCz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleDe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleEs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleFr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleIt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleJa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleLt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleLv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitlePl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitlePt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\City whereTitleUa($value)
 * @mixin \Eloquent
 */
class City extends Model
{
    protected $table = '_cities';
    protected $primaryKey = 'city_id';
    protected $fillable = ['title_en'];
    protected $visible = [
        'city_id', 'country_id', 'title_ru', 'title_en', 'area_ru', 'area_en',
        'region_ru', 'region_en',
    ];
    public $timestamps = [];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }
}
