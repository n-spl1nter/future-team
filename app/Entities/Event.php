<?php

namespace App\Entities;

use App\Http\Requests\CreateEventRequest;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


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
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property int $user_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event findSimilarSlugs($attribute, $config, $slug)
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereUserId($value)
 * @mixin \Eloquent
 * @property int $country_id
 * @property array|null $video_links
 * @property-read \App\Entities\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereVideoLinks($value)
 * @property array $domains
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereDomains($value)
 */
class Event extends Model
{
    use Sluggable, SluggableScopeHelpers, HasImage;

    const ACTIVE = 'ACTIVE';
    const EXPIRED = 'EXPIRED';
    const DELETED = 'DELETED';
    const BLOCKED = 'BLOCKED';

    protected $dates = ['start_at', 'end_at'];
    protected $fillable = ['name', 'conditions', 'reasons', 'contact_data', 'additional_info', 'city_id', 'country_id'];
    protected $hidden = ['updated_at'];
    protected $casts = [
        'domains' => 'array',
        'video_links' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['city.country.title_en', 'city.title_en', 'start_at'],
            ],
        ];
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getRouteKeyName()
    {
        return $this->getSlugKeyName();
    }

    public static function make(Request $request): self
    {
        $event = new self($request->all());
        $event->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('start_at'));
        $event->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('end_at'));
        $event->domains = array_values($request->get('domains'));
        $event->status = static::ACTIVE;
        $event->video_links = $request->get('video_links', []);
        $event->user_id = \Auth::id();
        $event->save();
        $event->setImage($request->file('photos'), MediaFile::TYPE_EVENT);

        return $event;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'images' => $this->getImages(MediaFile::TYPE_EVENT)->pluck('url')->toArray(),
        ]);
    }

    public function getAllInfo()
    {
        $this->load('city', 'user');
        return array_merge(parent::toArray(), [
            'images' => $this->getImages(MediaFile::TYPE_EVENT)->pluck('url')->toArray(),
        ]);
    }

    public static function getDistinctCountries()
    {
        return \DB::select(\DB::raw('SELECT DISTINCT events.country_id, _countries.title_ru, _countries.title_en FROM `events`
INNER JOIN _countries ON _countries.country_id = events.country_id'));
    }
}
