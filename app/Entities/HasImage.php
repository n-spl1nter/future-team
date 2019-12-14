<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;

trait HasImage
{
    /**
     * @param UploadedFile | UploadedFile[] | \stdClass $photo
     * @param string $imageType
     * @param int $fullWidth
     * @param int $smallWidth
     * @param int $quality
     * @param array $cropProperties
     */
    protected function setImage($photo, string $imageType, int $fullWidth = 1920, int $smallWidth = 1280, int $quality = 75, $cropProperties = []): void
    {
        if (is_array($photo)) {
            foreach ($photo as $photoItem) {
                $this->setImage($photoItem, $imageType, $fullWidth, $smallWidth, $quality);
            }
            return;
        }
        list($fullFileName, $smallFileName) = MediaFile::createFileNameByFileType($photo, $imageType);
        if ($photo instanceof \stdClass) {
            $image = \Image::make($photo->resource);
        } else {
            $image = \Image::make($photo);
        }
        if (!empty($cropProperties)) {
            $image = $image->crop($cropProperties['width'], $cropProperties['height'], $cropProperties['x'], $cropProperties['y']);
        }
        $image->widen($fullWidth)
            ->save(storage_path('app/public/') . $fullFileName, $quality)
            ->widen($smallWidth)
            ->save(storage_path('app/public/') . $smallFileName);
        MediaFile::addFile(self::class, $this->id, $imageType, [$fullFileName, $smallFileName]);
    }

    protected function cropImage($photo, int $width, int $height, int $x, int $y): Image
    {
        return \Image::make($photo)->crop($width, $height, $x, $y);
    }

    /**
     * @param string $type
     * @return Collection
     */
    public function getImages(string $type): Collection
    {
        return MediaFile::whereEntity(self::class)
            ->whereEntityId($this->id)
            ->whereFileType($type)
            ->get();
    }

    /**
     * @param string $type
     * @return MediaFile|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getImage(string $type)
    {
        return MediaFile::whereEntity(self::class)
            ->whereEntityId($this->id)
            ->whereFileType($type)
            ->first();
    }
}
