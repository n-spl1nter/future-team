<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Review
 *
 * @property int $id
 * @property string $name_ru
 * @property string $name_en
 * @property string $text_ru
 * @property string $text_en
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereNameRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereTextEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereTextRu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Model
{
    protected $table = 'reviews';
    protected $fillable = ['title_ru', 'title_en', 'text_ru', 'text_en', 'country_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }
}
