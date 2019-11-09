<?php

namespace App\Entities;

use App\Http\Requests\CreateEventRequest;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
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
 */
class Event extends Model
{
    use Sluggable, SluggableScopeHelpers;

    const ACTIVE = 0;
    const EXPIRED = 1;
    const DELETED = 2;
    const BLOCKED = 3;

    protected $dates = ['start_at', 'end_at'];
    protected $fillable = ['name', 'conditions', 'reasons', 'contact_data', 'additional_info', 'city_id'];
    protected $hidden = ['updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['city.country.title_en', 'city.title_en', 'start_at',],
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

    public function getRouteKeyName()
    {
        return $this->getSlugKeyName();
    }

    protected function setImages(CreateEventRequest $request): void
    {
        foreach ($request->file('photos') as $file) {
            list($fullFileName, $smallFileName) = MediaFile::createFileNameByFileType($file, MediaFile::TYPE_EVENT);
            $image = \Image::make($file);
            $image->save(storage_path('app/public/') . $fullFileName, 75)
                ->widen(1280)
                ->widen(450)
                ->save(storage_path('app/public/') . $smallFileName);
            MediaFile::addFile(self::class, $this->id, MediaFile::TYPE_EVENT, [$fullFileName, $smallFileName]);
        }
    }

    public static function make(CreateEventRequest $request): self
    {
        $event = new self($request->all());
        $event->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('start_at'));
        $event->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('end_at'));
        $event->status = static::ACTIVE;
        $event->user_id = \Auth::id();
        $event->save();
        $event->setImages($request);

        return $event;
    }
}
