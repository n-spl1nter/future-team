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
    protected $fillable = ['name', 'about', 'success_secret', 'city_id'];
    protected $hidden = ['updated_at'];
    protected $casts = [
        'domains' => 'array',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function make(Request $request): self
    {
        $action = new self($request->all());
        $action->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('start_at'));
        $action->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('end_at'));
        $action->status = static::ACTIVE;
        $action->domains = $request->get('domains');
        $action->user_id = \Auth::id();
        $action->save();
        $action->setImage($request->file('photos'), MediaFile::TYPE_ACTION);

        return $action;
    }
}
