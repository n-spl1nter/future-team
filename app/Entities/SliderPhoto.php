<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * App\Entities\MainPhoto
 *
 * @property int $id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SliderPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SliderPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SliderPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SliderPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SliderPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SliderPhoto whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entities\SliderPhoto whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SliderPhoto extends Model
{
    use HasImage;

    protected $table = 'main_photos';
    protected $fillable = ['order'];
    protected $visible = ['id'];

    public function setPhoto(UploadedFile $file = null): void
    {
        if (!$file) {
            return;
        }

        MediaFile::removeFile(self::class, $this->id, MediaFile::TYPE_SLIDER_PHOTO);
        $this->setImage($file, MediaFile::TYPE_SLIDER_PHOTO, 1280, 640, 100);
    }

    public function getPhoto()
    {
        $photo = $this->getImage(MediaFile::TYPE_SLIDER_PHOTO);
        return $photo ? $photo->url : [];
    }

    public function remove()
    {
        MediaFile::removeFile(self::class, $this->id, MediaFile::TYPE_SLIDER_PHOTO);
        return $this->delete();
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'photo' => $this->getPhoto(),
        ];
    }
}
