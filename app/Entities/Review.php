<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

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
    use HasImage;

    protected $table = 'reviews';
    protected $fillable = ['name_ru', 'name_en', 'text_ru', 'text_en', 'country_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'country_id');
    }

    public function setAvatar(UploadedFile $file = null): void
    {
        if (!$file) {
            return;
        }
        MediaFile::removeFile(self::class, $this->id, MediaFile::REVIEW_AVATAR);
        $this->setImage($file, MediaFile::REVIEW_AVATAR, 640, 240);
    }

    public function setFlag(UploadedFile $file = null): void
    {
        if (!$file) {
            return;
        }
        MediaFile::removeFile(self::class, $this->id, MediaFile::REVIEW_FLAG);
        $this->setImage($file, MediaFile::REVIEW_FLAG, 32, 16, 100);
    }

    public function getAvatar()
    {
        $avatar = $this->getImage(MediaFile::REVIEW_AVATAR);
        if (!$avatar) {
            return [];
        }
        return $avatar->url;
    }

    public function getFlag()
    {
        $flag = $this->getImage(MediaFile::REVIEW_FLAG);
        if (!$flag) {
            return [];
        }
        return $flag->url;
    }

    public function toArray()
    {
        return array_merge(parent::toArray(), [
            'country' => $this->country,
            'avatar' => $this->getAvatar(),
            'flag' => $this->getflag(),
        ]);
    }
}
