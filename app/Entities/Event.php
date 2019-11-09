<?php

namespace App\Entities;

use App\Http\Requests\CreateEventRequest;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    use Sluggable, SluggableScopeHelpers;

    const ACTIVE = 'ACTIVE';
    const EXPIRED = 'EXPIRED';
    const DELETED = 'DELETED';
    const BLOCKED = 'BLOCKED';

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

    public function getImages(): Collection
    {
        return MediaFile::whereEntity(self::class)
            ->whereEntityId($this->id)
            ->whereFileType(MediaFile::TYPE_EVENT)
            ->get();
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

    public function toArray()
    {
        $this->load('city');
        return array_merge(parent::toArray(), [
            'images' => $this->getImages()->toArray(),
        ]);

    }
}
