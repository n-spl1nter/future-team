<?php

namespace App\Entities;

use App\Http\Requests\CreateEventRequest;
use Carbon\Carbon;
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Entities\City $city
 * @property-read \App\Entities\User $user
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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\Event whereUserId($value)
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function setImages(CreateEventRequest $request): void
    {
        foreach ($request->file('photos') as $file) {
            list($fullFileName, $smallFileName) = MediaFile::createFileNameByFileType($file, MediaFile::TYPE_EVENT);
            $image = \Image::make();
        }
    }

    public static function make(CreateEventRequest $request): self
    {
        $event = new self($request->all());
        $event->start_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('start_at'));
        $event->end_at = Carbon::createFromFormat('Y-m-d H:i:s', $request->get('end_at'));
        $event->status = static::ACTIVE;
        $event->setImages($request);
    }
}
