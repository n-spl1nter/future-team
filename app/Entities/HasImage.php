<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

trait HasImage
{
    /**
     * @param UploadedFile | UploadedFile[] $photo
     * @param string $imageType
     * @param int $fullWidth
     * @param int $smallWidth
     * @param int $quality
     */
    protected function setImage($photo, string $imageType, int $fullWidth = 1280, int $smallWidth = 450, int $quality = 75): void
    {
        if (is_array($photo)) {
            foreach ($photo as $photoItem) {
                $this->setImage($photoItem, $imageType, $fullWidth, $smallWidth, $quality);
            }
            return;
        }
        list($fullFileName, $smallFileName) = MediaFile::createFileNameByFileType($photo, $imageType);
        $image = \Image::make($photo);
        $image->widen($fullWidth)
            ->save(storage_path('app/public/') . $fullFileName, $quality)
            ->widen($smallWidth)
            ->save(storage_path('app/public/') . $smallFileName);
        MediaFile::addFile(self::class, $this->id, $imageType, [$fullFileName, $smallFileName]);
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
