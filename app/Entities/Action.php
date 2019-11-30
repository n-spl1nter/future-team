<?php

namespace App\Entities;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * App\Entities\Action
 *
 * @property int $id
 * @property string $name
 * @property string $about
 * @property string $success_secret
 * @property int $city_id
 * @property string $status
 * @property string $slug
 * @property string $domains
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action findSimilarSlugs($attribute, $config, $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereDomains($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereSuccessSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entities\User[] $joinedUsers
 * @property-read int|null $joined_users_count
 * @property int $country_id
 * @property array|null $video_links
 * @property-read \App\Entities\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Action whereVideoLinks($value)
 */
class Action extends Model
{
    use Sluggable, SluggableScopeHelpers, HasImage;

    const ACTIVE = 'ACTIVE';
    const EXPIRED = 'EXPIRED';
    const DELETED = 'DELETED';
    const BLOCKED = 'BLOCKED';

    protected $table = 'actions';
    protected $dates = ['start_at', 'end_at'];
    protected $fillable = ['name', 'about', 'success_secret', 'city_id', 'country_id'];
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

    public function joinedUsers()
    {
        return $this->belongsToMany(User::class, 'users_to_actions', 'action_id', 'user_id')
            ->withTimestamps();
    }

    public static function make(Request $request): self
    {
        $action = new self($request->all());
        $action->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('start_at'));
        $action->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('end_at'));
        $action->status = static::ACTIVE;
        $action->domains = array_values($request->get('domains'));
        $action->video_links = $request->get('video_links', []);
        $action->user_id = \Auth::id();
        $action->save();
        $action->setImage($request->file('photos'), MediaFile::TYPE_ACTION);

        return $action;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'images' => $this->getImages(MediaFile::TYPE_ACTION)->pluck('url')->toArray(),
        ]);
    }

    public function getAllInfo()
    {
        $this->load('city', 'user');
        return array_merge(parent::toArray(), [
            'images' => $this->getImages(MediaFile::TYPE_ACTION)->pluck('url')->toArray(),
        ]);
    }

    public function joinMember(User $user): bool
    {
        if ($this->joinedUsers()->where('user_id', $user->id)->count() > 0) {
            return false;
        }

        $this->joinedUsers()->attach($user->id);
        return true;
    }

    public static function getDistinctCountries(Request $request)
    {
        $query = "SELECT DISTINCT actions.country_id, _countries.title_ru, _countries.title_en FROM `actions`
INNER JOIN _countries ON _countries.country_id = actions.country_id";
        if ($request->get('status') == 'archive') {
            $query .= " WHERE actions.end_at < NOW()";
        } elseif ($request->get('status') == 'active') {
            $query .= " WHERE actions.end_at > NOW()";
        }
        return \DB::select(\DB::raw($query));
    }
}
