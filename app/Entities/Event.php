<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entities\Event
 *
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property string $conditions
 * @property string $reasons
 * @property string $contact_data
 * @property string $additional_info
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\City $city
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereAdditionalInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereConditions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereContactData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereReasons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    const ACTIVE = 0;
    const EXPIRED = 1;
    const DELETED = 2;
    const BLOCKED = 3;

    protected $dates = ['start_at', 'end_at'];
    protected $fillable = ['name', 'conditions', 'reasons', 'contact_data', 'additional_info'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public static function make()
    {

    }

    public static function getOnCreateValidationRules(): array
    {
        return [
            'name' => 'required|string|min:5|max:255',
            'conditions' => 'required|string|min:5|max:1000',
            'reasons' => 'required|string|min:5|max:400',
            'contact_data' => 'required|string|min:5|max:255',
            'additional_info' => 'required|string|min:5|max:1000',
            'photos' => 'required|array|min:3|max:5',
            'photos.*' => 'required|image|mimes:jpeg,bmp,png|dimensions:min_width=800,min_height=800',
            'city_id' => 'required|integer|exists:_cities,city_id',
            'start_at' => 'required|date|after:tomorrow',
            'end_at' => 'required|date|after:start_at',
        ];
    }
}
